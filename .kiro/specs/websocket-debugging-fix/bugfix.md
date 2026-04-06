# Bugfix Requirements Document

## Introduction

Sistem E-Kantin menggunakan WebSocket untuk notifikasi real-time pesanan baru (OrderMasuk) dan update status pesanan (OrderStatusUpdated). Saat ini terdapat error kritis: **"Uncaught You must pass your app key when you instantiate Pusher"** yang disebabkan oleh environment variables Vite tidak terbaca dengan benar. Proyek memiliki dua broadcaster terinstal (Pusher dan Reverb) namun konfigurasi tidak konsisten. Requirement: gunakan **Reverb untuk development** dan **Pusher untuk production deployment**, dengan mekanisme debugging dan dokumentasi lengkap.

## Bug Analysis

### Current Behavior (Defect)

1.1 WHEN aplikasi dijalankan dengan `npm run dev` THEN muncul error "Uncaught You must pass your app key when you instantiate Pusher" karena `VITE_PUSHER_APP_KEY` tidak terbaca dari `.env`

1.2 WHEN `resources/js/echo.js` mencoba membaca `import.meta.env.VITE_PUSHER_APP_KEY` THEN nilai undefined karena Vite tidak load environment variables dengan benar

1.3 WHEN `.env` menggunakan `BROADCAST_CONNECTION=pusher` dengan kredensial Pusher THEN sistem menggunakan Pusher tetapi `.env.example` menunjukkan konfigurasi Reverb yang berbeda, menyebabkan kebingungan deployment

1.4 WHEN developer ingin menggunakan Reverb untuk development dan Pusher untuk production THEN tidak ada mekanisme untuk switch broadcaster berdasarkan environment

1.5 WHEN koneksi WebSocket gagal (network error, kredensial salah, atau server tidak tersedia) THEN tidak ada error handling atau logging yang mencatat kegagalan tersebut

1.6 WHEN Echo gagal subscribe ke channel `kios.{id}` atau `user.{id}` THEN tidak ada fallback mechanism dan user tidak mendapat notifikasi error

1.7 WHEN developer perlu debug WebSocket issues THEN tidak ada console logging, connection status indicator, atau debugging tools yang tersedia

1.8 WHEN event `OrderMasuk` atau `OrderStatusUpdated` di-broadcast THEN tidak ada logging di backend untuk memverifikasi event berhasil dikirim

1.9 WHEN dokumentasi proyek dibaca THEN tidak ada dokumentasi tentang setup WebSocket, troubleshooting, atau cara beralih antara Pusher dan Reverb

### Expected Behavior (Correct)

2.1 WHEN aplikasi dijalankan dengan `npm run dev` THEN Vite SHALL membaca environment variables dari `.env` dan `VITE_PUSHER_APP_KEY` atau `VITE_REVERB_APP_KEY` tersedia di `import.meta.env`

2.2 WHEN `echo.js` diinisialisasi THEN sistem SHALL membaca broadcaster type dari environment variable dan menggunakan konfigurasi yang sesuai (Reverb untuk development, Pusher untuk production)

2.3 WHEN `.env` dikonfigurasi untuk development THEN sistem SHALL menggunakan Reverb dengan `BROADCAST_CONNECTION=reverb` dan kredensial Reverb yang valid

2.4 WHEN aplikasi di-deploy ke production THEN sistem SHALL menggunakan Pusher dengan `BROADCAST_CONNECTION=pusher` dan kredensial Pusher yang valid

2.5 WHEN koneksi WebSocket gagal THEN sistem SHALL menangkap error, log ke console dengan detail yang jelas (broadcaster type, credentials status, network error), dan menampilkan pesan error yang informatif

2.6 WHEN Echo gagal subscribe ke channel THEN sistem SHALL retry connection dengan exponential backoff dan log setiap attempt dengan timestamp

2.7 WHEN developer mengaktifkan debug mode THEN sistem SHALL menampilkan connection status, channel subscriptions, event logs, dan broadcaster info di browser console

2.8 WHEN event broadcast di-dispatch dari backend THEN sistem SHALL log event name, channel, payload summary, dan broadcast status untuk debugging purposes

2.9 WHEN dokumentasi proyek dibaca THEN SHALL tersedia dokumentasi lengkap tentang: setup Reverb untuk development, setup Pusher untuk production, troubleshooting guide untuk error "app key" dan connection failures, dan testing procedures

### Unchanged Behavior (Regression Prevention)

3.1 WHEN event `OrderMasuk` di-broadcast ke kiosk owner THEN sistem SHALL CONTINUE TO mengirim notifikasi real-time ke channel `kios.{kioskId}` dengan payload order yang sama

3.2 WHEN event `OrderStatusUpdated` di-broadcast ke customer THEN sistem SHALL CONTINUE TO mengirim notifikasi ke channel `user.{userId}` dengan payload order dan message yang sama

3.3 WHEN kiosk owner menerima notifikasi OrderMasuk THEN sistem SHALL CONTINUE TO memutar audio notification, menampilkan modal, dan auto-refresh halaman orders

3.4 WHEN Web Push notification dikirim via `WebPushService` THEN sistem SHALL CONTINUE TO berfungsi independen dari WebSocket dan mengirim push notification ke Service Worker

3.5 WHEN channel authorization di `routes/channels.php` divalidasi THEN sistem SHALL CONTINUE TO memverifikasi user memiliki akses ke channel `kios.{kioskId}` atau `user.{id}`

3.6 WHEN `ShouldBroadcastNow` interface digunakan pada events THEN sistem SHALL CONTINUE TO broadcast secara synchronous tanpa queue

3.7 WHEN user tidak memiliki akses ke channel THEN sistem SHALL CONTINUE TO menolak subscription dengan 403 Forbidden

3.8 WHEN aplikasi berjalan di production dengan Pusher credentials yang valid THEN sistem SHALL CONTINUE TO berfungsi normal tanpa perubahan behavior
