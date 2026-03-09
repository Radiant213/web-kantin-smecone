// Service Worker for E-Kantin Push Notifications
self.addEventListener('push', function (event) {
    let data = { title: '🔔 Pesanan Baru!', body: 'Ada pesanan baru masuk ke kios Anda.' };

    try {
        data = event.data.json();
    } catch (e) {
        // Use default data
    }

    const options = {
        body: data.body || 'Segera cek halaman Pesanan Toko.',
        icon: '/favicon.jpg',
        badge: '/favicon.jpg',
        tag: data.tag || 'order-notification',
        requireInteraction: true,
        vibrate: [300, 100, 300, 100, 300],
        data: {
            url: data.url || '/',
        },
        actions: [
            { action: 'open', title: 'Lihat Pesanan' },
            { action: 'dismiss', title: 'Tutup' },
        ]
    };

    event.waitUntil(
        self.registration.showNotification(data.title || '🔔 Pesanan Baru!', options)
    );
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    if (event.action === 'dismiss') return;

    const url = event.notification.data?.url || '/';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (clientList) {
            // If a window is already open, focus it
            for (let i = 0; i < clientList.length; i++) {
                const client = clientList[i];
                if (client.url.includes(self.location.origin) && 'focus' in client) {
                    client.navigate(url);
                    return client.focus();
                }
            }
            // Otherwise open a new window
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});

self.addEventListener('install', function (event) {
    self.skipWaiting();
});

self.addEventListener('activate', function (event) {
    event.waitUntil(self.clients.claim());
});
