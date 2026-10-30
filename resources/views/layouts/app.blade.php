<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="vapid-pub-key" content="{{ config('app.vapid_public_key', env('VAPID_PUBLIC_KEY')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="SMECONE E-Kantin • Platform Digital Canteen Resmi SMK Negeri 1 Purwokerto">

    <title>{{ config('app.name', 'SMECONE E-Kantin') }} - @yield('title', 'Beranda')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-smecone.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="bg-slate-50 font-sans text-slate-800 antialiased min-h-screen flex flex-col" x-data="{ loaded: false }"
    x-init="setTimeout(() => loaded = true, 50)">

    {{-- ═══ Institutional Navbar ═══ --}}
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200/80 shadow-sm"
        x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18 py-2">
                
                {{-- Brand Lockup with School Crest --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo-smecone.png') }}" alt="Logo SMECONE" 
                         class="w-11 h-11 object-contain drop-shadow-sm group-hover:scale-105 transition-transform duration-200">
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-lg font-black tracking-tight text-slate-900">SMECONE</span>
                            <span class="text-xs font-bold px-1.5 py-0.5 rounded bg-primary-800 text-white tracking-wider">E-KANTIN</span>
                        </div>
                        <p class="text-[11px] font-medium text-slate-500">SMK Negeri 1 Purwokerto</p>
                    </div>
                </a>

                {{-- Desktop Navigation Links --}}
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('home') }}"
                        class="text-sm font-semibold {{ request()->routeIs('home') ? 'text-primary-800' : 'text-slate-600 hover:text-primary-800' }} transition-colors">
                        Beranda
                    </a>

                    @auth
                        @if(auth()->user()->isPenjual())
                            {{-- Penjual Orders Dropdown --}}
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button @click="open = ! open" 
                                    class="flex items-center text-sm font-semibold {{ request()->routeIs('orders.*') || request()->routeIs('penjual.orders.*') ? 'text-primary-800' : 'text-slate-600 hover:text-primary-800' }} transition-colors">
                                    Pesanan
                                    <svg class="w-4 h-4 ml-1 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="open" x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     class="absolute z-50 mt-2 w-48 rounded-xl shadow-lg bg-white border border-slate-100 py-1"
                                     style="display: none;">
                                    <a href="{{ route('orders.index') }}" 
                                       class="block px-4 py-2 text-sm font-medium {{ request()->routeIs('orders.index') ? 'bg-primary-50 text-primary-800' : 'text-slate-700 hover:bg-slate-50' }}">
                                        Pesanan Saya
                                    </a>
                                    <a href="{{ route('penjual.orders.index') }}" 
                                       class="block px-4 py-2 text-sm font-medium {{ request()->routeIs('penjual.orders.index') ? 'bg-primary-50 text-primary-800' : 'text-slate-700 hover:bg-slate-50' }}">
                                        Pesanan Kios Saya
                                    </a>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('orders.index') }}"
                                class="text-sm font-semibold {{ request()->routeIs('orders.*') ? 'text-primary-800' : 'text-slate-600 hover:text-primary-800' }} transition-colors">
                                Pesanan Saya
                            </a>
                        @endif

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="text-sm font-semibold text-slate-600 hover:text-primary-800 transition-colors">
                                Dashboard Admin
                            </a>
                        @endif
                    @endauth

                    {{-- Cart Icon with Badge --}}
                    @php $cartCount = count(session('cart', [])); @endphp
                    <a href="{{ route('cart.index') }}" 
                       class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 hover:bg-primary-50 text-slate-700 hover:text-primary-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-primary-800 text-white rounded-full text-[11px] font-bold flex items-center justify-center animate-pulse">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    {{-- User Profile / Auth State --}}
                    @auth
                        <div class="relative" x-data="{ userMenu: false }" @click.away="userMenu = false">
                            <button @click="userMenu = !userMenu" 
                                class="flex items-center gap-2.5 p-1.5 rounded-full hover:bg-slate-100 transition-colors border border-slate-200">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-7 h-7 rounded-full object-cover">
                                @else
                                    <div class="w-7 h-7 rounded-full bg-primary-800 text-white text-xs font-bold flex items-center justify-center">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="text-xs font-bold text-slate-800 pr-1 max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                                <svg class="w-3.5 h-3.5 text-slate-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="userMenu" x-transition class="absolute right-0 mt-2 w-52 rounded-xl shadow-lg bg-white border border-slate-100 py-1.5 z-50" style="display: none;">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-xs text-slate-400">Masuk sebagai</p>
                                    <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                                    <span class="inline-block mt-0.5 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-slate-100 text-slate-600">
                                        {{ auth()->user()->role ?? 'Warga SMECONE' }}
                                    </span>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 font-medium">Pengaturan Profil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 font-medium">Keluar</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" 
                               class="text-xs font-bold px-4 py-2 text-primary-800 hover:bg-primary-50 rounded-xl transition-colors">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" 
                               class="text-xs font-bold px-4 py-2 bg-primary-800 text-white rounded-xl hover:bg-primary-900 transition-colors shadow-sm">
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>

                {{-- Mobile Menu Trigger --}}
                <div class="flex md:hidden items-center gap-2">
                    @php $cartCount = count(session('cart', [])); @endphp
                    <a href="{{ route('cart.index') }}" class="relative p-2 rounded-xl bg-slate-100 text-slate-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-primary-800 text-white rounded-full text-[10px] font-bold flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <button @click="mobileOpen = !mobileOpen" class="p-2 rounded-xl bg-slate-100 text-slate-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Dropdown Menu --}}
            <div x-show="mobileOpen" x-transition class="md:hidden py-4 border-t border-slate-100 space-y-2" style="display: none;">
                <a href="{{ route('home') }}" class="block px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100">Beranda</a>
                @auth
                    <a href="{{ route('orders.index') }}" class="block px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100">Pesanan Saya</a>
                    @if(auth()->user()->isPenjual())
                        <a href="{{ route('penjual.orders.index') }}" class="block px-4 py-2 rounded-xl text-sm font-semibold text-primary-800 hover:bg-primary-50">Pesanan Kios</a>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100">Admin Dashboard</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100">Profil Saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 rounded-xl text-sm font-semibold text-rose-600 hover:bg-rose-50">Keluar</button>
                    </form>
                @else
                    <div class="grid grid-cols-2 gap-2 pt-2">
                        <a href="{{ route('login') }}" class="text-center py-2.5 rounded-xl text-sm font-bold bg-slate-100 text-slate-800">Masuk</a>
                        <a href="{{ route('register') }}" class="text-center py-2.5 rounded-xl text-sm font-bold bg-primary-800 text-white">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ═══ Global Flash Messages ═══ --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
            class="fixed top-20 right-4 z-50 bg-emerald-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-semibold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
            class="fixed top-20 right-4 z-50 bg-rose-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-semibold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- ═══ Main Body Content ═══ --}}
    <main class="flex-1">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    {{-- ═══ Official SMECONE Footer ═══ --}}
    <footer class="bg-white border-t border-slate-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                {{-- Col 1: Identity --}}
                <div class="md:col-span-2 space-y-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-smecone.png') }}" alt="Logo SMECONE" class="w-10 h-10 object-contain">
                        <div>
                            <span class="text-base font-black text-slate-900 tracking-tight">SMECONE E-KANTIN</span>
                            <p class="text-xs text-slate-500 font-medium">SMK Negeri 1 Purwokerto</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed max-w-md">
                        Platform pemesanan makanan mandiri untuk lingkungan SMK Negeri 1 Purwokerto. 
                        Pre-order sebelum bel istirahat, bayar digital via Midtrans QRIS, dan ambil cepat tanpa antre.
                    </p>
                    <p class="text-[11px] text-slate-400">
                        📍 Jl. Dr. Soeparno No. 29, Purwokerto Wetan, Kec. Purwokerto Timur, Kab. Banyumas, Jawa Tengah 53111
                    </p>
                </div>

                {{-- Col 2: Zona Kantin --}}
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-3">Zona Kantin</h4>
                    <ul class="space-y-2 text-xs text-slate-600 font-medium">
                        <li>• Kantin Pemasaran (Depan)</li>
                        <li>• Kantin Corner</li>
                        <li>• Kantin Belakang</li>
                    </ul>
                </div>

                {{-- Col 3: Jadwal Istirahat --}}
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-3">Sesi Istirahat</h4>
                    <ul class="space-y-2 text-xs text-slate-600 font-medium">
                        <li>⏰ <strong>Istirahat 1:</strong> 09:45 - 10:15 WIB</li>
                        <li>⏰ <strong>Istirahat 2:</strong> 12:00 - 12:45 WIB</li>
                    </ul>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-2">
                <p>&copy; {{ date('Y') }} SMK Negeri 1 Purwokerto • Hak Cipta Dilindungi.</p>
                <p class="font-medium">Full Cashless via Midtrans QRIS • Real-Time WebSockets</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
