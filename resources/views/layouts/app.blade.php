<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="vapid-pub-key" content="{{ config('app.vapid_public_key', env('VAPID_PUBLIC_KEY')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="E-Kantin SMKN 1 Purwokerto - Jajan Gampang, Perut Kenyang">
    <meta name="keywords" content="kantin smknegeri 1 purwokerto, kantin smkn 1 purwokerto, e-kantin smkn 1 purwokerto, jajan online smkn 1 purwokerto, kantin online smecone">
    <meta name="author" content="SMKN 1 Purwokerto">
    <title>{{ config('app.name', 'E-Kantin') }} - @yield('title', 'Home')</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('favicon.jpg') }}?v=2">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans antialiased min-h-screen flex flex-col" x-data="{ loaded: false }"
    x-init="setTimeout(() => loaded = true, 100)">

    {{-- ═══ Navbar ═══ --}}
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-gray-100 shadow-sm"
        x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('favicon.jpg') }}" alt="Logo E-Kantin" class="w-10 h-10 object-contain rounded-xl shadow-sm border border-gray-100 bg-white">
                    <span class="text-xl font-bold text-gray-800">E-<span class="text-primary-500">Kantin</span></span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('home') }}"
                        class="text-sm font-medium {{ request()->routeIs('home') ? 'text-primary-500' : 'text-gray-600 hover:text-primary-500' }} transition-colors">Home</a>

                    @auth
                        @if(auth()->user()->isPenjual())
                            {{-- Penjual Orders Dropdown --}}
                            <div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                                <button @click="open = ! open" class="flex items-center text-sm font-medium {{ request()->routeIs('orders.*') || request()->routeIs('penjual.orders.*') ? 'text-primary-500' : 'text-gray-600 hover:text-primary-500' }} transition-colors">
                                    Pesanan
                                    <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div x-show="open"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute z-50 mt-2 w-48 rounded-md shadow-lg object-top bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                        style="display: none;">
                                    <div class="py-1">
                                        <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('orders.index') ? 'bg-primary-50 text-primary-600 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">Pesanan Saya</a>
                                        <a href="{{ route('penjual.orders.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('penjual.orders.index') ? 'bg-primary-50 text-primary-600 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">Pesanan Toko</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Pembeli or Admin Order Link --}}
                            <a href="{{ route('orders.index') }}"
                                class="text-sm font-medium {{ request()->routeIs('orders.*') ? 'text-primary-500' : 'text-gray-600 hover:text-primary-500' }} transition-colors">Pesanan</a>
                        @endif
                        <a href="{{ route('profile.edit') }}"
                            class="text-sm font-medium {{ request()->routeIs('profile.*') ? 'text-primary-500' : 'text-gray-600 hover:text-primary-500' }} transition-colors">Profil</a>

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="text-sm font-medium text-gray-600 hover:text-primary-500 transition-colors">Admin</a>
                        @endif
                    @endauth

                    {{-- Cart Icon --}}
                    @auth
                        <a href="{{ route('cart.index') }}"
                            class="relative p-2 text-gray-600 hover:text-primary-500 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                            </svg>
                            @if(session('cart') && count(session('cart')) > 0)
                                <span
                                    class="absolute -top-1 -right-1 w-5 h-5 bg-primary-500 text-white text-xs font-bold rounded-full flex items-center justify-center">
                                    {{ count(session('cart')) }}
                                </span>
                            @endif
                        </a>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="btn-primary-sm">Masuk</a>
                    @else
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-sm font-medium text-gray-600 hover:text-red-500 transition-colors">Keluar</button>
                        </form>
                    @endguest
                </div>

                {{-- Mobile Hamburger --}}
                <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-gray-600 hover:text-primary-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden bg-white border-t border-gray-100 shadow-lg" x-cloak>
            <div class="px-4 py-3 space-y-2">
                <a href="{{ route('home') }}"
                    class="block px-4 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('home') ? 'bg-primary-50 text-primary-600' : 'text-gray-600 hover:bg-gray-50' }}">Home</a>

                @auth
                    @if(auth()->user()->isPenjual())
                        <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">PESANAN</div>
                        <a href="{{ route('orders.index') }}"
                            class="block px-4 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('orders.index') ? 'bg-primary-50 text-primary-600' : 'text-gray-600 hover:bg-gray-50' }}">Pesanan Saya</a>
                        <a href="{{ route('penjual.orders.index') }}"
                            class="block px-4 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('penjual.orders.index') ? 'bg-primary-50 text-primary-600' : 'text-gray-600 hover:bg-gray-50' }}">Pesanan Toko</a>
                    @else
                        <a href="{{ route('orders.index') }}"
                            class="block px-4 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('orders.index') ? 'bg-primary-50 text-primary-600' : 'text-gray-600 hover:bg-gray-50' }}">Pesanan</a>
                    @endif
                    <a href="{{ route('cart.index') }}"
                        class="block px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50">Keranjang</a>
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50">Profil</a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50">Admin</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 rounded-xl text-sm font-medium text-red-500 hover:bg-red-50">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="block px-4 py-2 rounded-xl text-sm font-medium bg-primary-500 text-white text-center">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="block px-4 py-2 rounded-xl text-sm font-medium text-primary-500 text-center border border-primary-500">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ═══ Flash Messages ═══ --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
            class="fixed top-20 right-4 z-50 bg-emerald-500 text-white px-6 py-3 rounded-xl shadow-lg text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
            class="fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg text-sm font-medium">
            {{ session('error') }}
        </div>
    @endif

    {{-- ═══ Main Content ═══ --}}
    <main class="flex-1 transition-all duration-700 ease-out transform"
        :class="loaded ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    {{-- ═══ Footer ═══ --}}
    <footer class="bg-white border-t border-gray-100 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('favicon.jpg') }}" alt="Logo E-Kantin" class="w-8 h-8 object-contain rounded-lg border border-gray-100 bg-white">
                    <span class="text-sm font-semibold text-gray-700">E-<span class="text-primary-500">Kantin</span>
                        SMKN 1 Purwokerto</span>
                </div>
                <p class="text-xs text-gray-400">&copy; {{ date('Y') }} E-Kantin. All rights reserved.</p>
            </div>
        </div>
    </footer>


    {{-- ═══ Global Order Notification (Penjual Only) ═══ --}}
    @auth
        @if(auth()->user()->isPenjual() && auth()->user()->kiosks()->first())
            <div x-data="{
                showOrderModal: false,
                currentOrder: null,
                audioEnabled: localStorage.getItem('audioEnabled') === 'true',
                init() {
                    // Auto-init audio if previously enabled
                    if (this.audioEnabled && !window.orderAudio) {
                        window.orderAudio = new Audio('/sounds/notification.mp3');
                        window.orderAudio.volume = 0.8;
                    }

                    // Register Service Worker for Web Push
                    if ('serviceWorker' in navigator && 'PushManager' in window) {
                        navigator.serviceWorker.register('/sw.js').then(reg => {
                            // If audio is enabled, ensure we are subscribed to web push
                            if (this.audioEnabled) {
                                this.subscribeUserToPush(reg);
                            }
                        });
                    }

                    // Listen for new orders via Echo (WebSocket foreground)
                    if (typeof Echo !== 'undefined') {
                        Echo.private('kios.{{ auth()->user()->kiosks()->first()->id }}')
                            .listen('OrderMasuk', (e) => {
                                // Auto-refresh if on Orders page
                                if (window.location.pathname.includes('/penjual/orders')) {
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1500); // Give the user 1.5s to read the sweet alert or notification before refreshing
                                }

                                // Re-check localStorage in case toggled on another tab
                                this.audioEnabled = localStorage.getItem('audioEnabled') === 'true';
                                if (this.audioEnabled) {
                                    if (!window.orderAudio) {
                                        window.orderAudio = new Audio('/sounds/notification.mp3');
                                        window.orderAudio.volume = 0.8;
                                    }
                                    window.orderAudio.loop = true;
                                    window.orderAudio.play().catch(err => console.log('Autoplay blocked:', err));
                                }
                                this.currentOrder = e.order;
                                this.showOrderModal = true;

                                // Send browser native notification (if foreground)
                                if ('Notification' in window && Notification.permission === 'granted') {
                                    const total = e.order ? 'Rp ' + Number(e.order.total_price).toLocaleString('id-ID') : '';
                                    const notif = new Notification('🔔 Pesanan Baru Masuk!', {
                                        body: 'Subtotal: ' + total + '\nSegera cek halaman Pesanan Toko.',
                                        icon: '/favicon.jpg',
                                        tag: 'order-' + (e.order?.id || Date.now()),
                                        requireInteraction: true,
                                    });
                                    notif.onclick = () => {
                                        window.focus();
                                        notif.close();
                                    };
                                }
                            });
                    }
                },
                
                // Helper to convert base64 to Uint8Array for VAPID
                urlB64ToUint8Array(base64String) {
                    const padding = '='.repeat((4 - base64String.length % 4) % 4);
                    const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
                    const rawData = window.atob(base64);
                    const outputArray = new Uint8Array(rawData.length);
                    for (let i = 0; i < rawData.length; ++i) {
                        outputArray[i] = rawData.charCodeAt(i);
                    }
                    return outputArray;
                },

                // Subscribe to Push API and send to backend
                subscribeUserToPush(swRegistration) {
                    swRegistration.pushManager.getSubscription()
                        .then(function(subscription) {
                            if (subscription) {
                                return subscription;
                            }
                            const vapidPublicKey = document.querySelector('meta[name=\'vapid-pub-key\']')?.getAttribute('content');
                            if(!vapidPublicKey) return null;
                            const convertedVapidKey = this.urlB64ToUint8Array(vapidPublicKey);
                            return swRegistration.pushManager.subscribe({
                                userVisibleOnly: true,
                                applicationServerKey: convertedVapidKey
                            });
                        }.bind(this))
                        .then(function(subscription) {
                            if(!subscription) return;
                            // Send to backend
                            fetch('/push-subscriptions', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                                },
                                body: JSON.stringify(subscription)
                            });
                        })
                        .catch(err => console.error('Failed to subscribe:', err));
                }
            }">
                {{-- Modal Notifikasi Pesanan Baru --}}
                <div x-show="showOrderModal" class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
                    <div x-show="showOrderModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>

                    <div class="fixed inset-0 z-10 w-screen overflow-y-auto mt-20">
                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                            <div x-show="showOrderModal" x-transition:enter="ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                x-transition:leave="ease-in duration-200"
                                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all border-4 border-primary-500 sm:my-8 sm:w-full sm:max-w-lg">
                                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 text-center">
                                    <div class="mx-auto flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full bg-primary-100 sm:mx-auto sm:h-20 sm:w-20 mb-4 animate-bounce">
                                        <svg class="h-10 w-10 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold leading-6 text-gray-900">Ada Pesanan Baru Masuk!</h3>
                                        <div class="mt-4 bg-gray-50 rounded-xl p-4 border border-gray-100 text-left">
                                            <p class="text-sm font-medium text-gray-500">Subtotal: <span
                                                    class="font-bold text-lg text-primary-600 ml-2"
                                                    x-text="currentOrder ? 'Rp ' + Number(currentOrder.total_price).toLocaleString('id-ID') : 'Rp 0'"></span>
                                            </p>
                                            <p class="text-xs text-gray-400 mt-2">Silakan cek halaman Pesanan Toko untuk detail item.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-3">
                                    <button type="button" @click="if(window.orderAudio) { window.orderAudio.pause(); window.orderAudio.currentTime = 0; } showOrderModal = false; window.location.href = '{{ route('penjual.orders.index') }}';"
                                        class="inline-flex w-full justify-center rounded-xl bg-primary-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 sm:w-auto transition-colors">Lihat & Terima Pesanan</button>
                                    <button type="button"
                                        @click="showOrderModal = false; if(window.orderAudio) { window.orderAudio.pause(); window.orderAudio.currentTime = 0; }"
                                        class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">Tutup Sementara</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    @stack('scripts')
</body>

</html>