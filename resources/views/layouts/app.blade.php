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

    {{-- ═══ Institutional Navbar (Clean & Modern) ═══ --}}
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs"
        x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18 py-2.5">
                
                {{-- Brand Lockup with School Crest --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-full overflow-hidden bg-white border border-slate-200 shadow-xs group-hover:scale-105 transition-transform duration-200 flex-shrink-0 flex items-center justify-center">
                        <img src="{{ asset('images/logo-smecone.png') }}" alt="Logo SMECONE" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-lg font-black tracking-tight text-slate-900">SMECONE</span>
                            <span class="text-xs font-extrabold px-1.5 py-0.5 rounded bg-primary-800 text-white tracking-wider">E-KANTIN</span>
                        </div>
                        <p class="text-[11px] font-medium text-slate-500">SMK Negeri 1 Purwokerto</p>
                    </div>
                </a>

                {{-- Right Actions: Cart & User Profile Dropdown --}}
                <div class="flex items-center gap-3">
                    
                    {{-- Cart Icon with Badge --}}
                    @php $cartCount = count(session('cart', [])); @endphp
                    <a href="{{ route('cart.index') }}" 
                       title="Baki Keranjang"
                       class="relative flex items-center justify-center w-11 h-11 rounded-2xl bg-slate-100 hover:bg-primary-50 text-slate-700 hover:text-primary-800 border border-slate-200/80 transition-all active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-primary-800 text-white rounded-full text-[11px] font-black flex items-center justify-center animate-pulse shadow-sm">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    @auth
                        {{-- User Profile Pill & All-in-One Dropdown --}}
                        <div class="relative" x-data="{ userDropdown: false }">
                            <button @click.stop="userDropdown = !userDropdown" type="button" id="user-menu-btn"
                                class="flex items-center gap-2.5 px-3 py-1.5 rounded-full hover:bg-slate-100 transition-all border border-slate-200/90 bg-white shadow-xs focus:outline-none focus:ring-2 focus:ring-primary-800/20 active:scale-98">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover shadow-xs border border-slate-200">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-primary-800 text-white text-xs font-extrabold flex items-center justify-center shadow-xs">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="text-left hidden sm:block">
                                    <span class="text-xs font-bold text-slate-800 block max-w-[120px] truncate leading-tight">{{ auth()->user()->name }}</span>
                                    <span class="text-[10px] text-slate-400 block font-medium capitalize">{{ auth()->user()->role ?? 'Siswa' }}</span>
                                </div>
                                <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="userDropdown ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            {{-- Dropdown Menu (Contains All Main Navigation) --}}
                            <div x-show="userDropdown" 
                                 @click.outside="userDropdown = false"
                                 id="user-dropdown-menu"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                 class="absolute right-0 mt-2.5 w-64 rounded-2xl shadow-2xl bg-white border border-slate-200/90 py-2 z-[999] ring-1 ring-slate-900/5 divide-y divide-slate-100" 
                                 style="display: none;">
                                
                                {{-- User Identity Header --}}
                                <div class="px-4 py-3 bg-slate-50/70 -mt-2 rounded-t-2xl border-b border-slate-100">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Akun Terdaftar</p>
                                    <p class="text-sm font-extrabold text-slate-900 truncate mt-0.5">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                                    <span class="inline-block mt-1.5 text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-primary-50 text-primary-800 border border-primary-200">
                                        {{ auth()->user()->role ?? 'Warga SMECONE' }}
                                    </span>
                                </div>

                                {{-- Navigation Links Inside Dropdown --}}
                                <div class="py-1.5 space-y-0.5 px-1.5">
                                    <a href="{{ route('home') }}" 
                                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('home') ? 'bg-primary-50 text-primary-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }} transition-colors">
                                        <svg class="w-4 h-4 {{ request()->routeIs('home') ? 'text-primary-800' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                        <span>Beranda Kantin</span>
                                    </a>

                                    <a href="{{ route('orders.index') }}" 
                                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('orders.index') ? 'bg-primary-50 text-primary-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }} transition-colors">
                                        <svg class="w-4 h-4 {{ request()->routeIs('orders.index') ? 'text-primary-800' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <span>Pesanan Saya (Nota)</span>
                                    </a>

                                    @if(auth()->user()->isPenjual())
                                        <a href="{{ route('penjual.orders.index') }}" 
                                           class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('penjual.orders.*') ? 'bg-primary-50 text-primary-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }} transition-colors">
                                            <svg class="w-4 h-4 {{ request()->routeIs('penjual.orders.*') ? 'text-primary-800' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                            </svg>
                                            <span>Pesanan Stand Kios</span>
                                        </a>
                                    @endif

                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" 
                                           class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-purple-50 hover:text-purple-800 transition-colors">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                            </svg>
                                            <span>Dashboard Admin</span>
                                        </a>
                                    @endif

                                    <a href="{{ route('profile.edit') }}" 
                                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('profile.*') ? 'bg-primary-50 text-primary-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }} transition-colors">
                                        <svg class="w-4 h-4 {{ request()->routeIs('profile.*') ? 'text-primary-800' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span>Pengaturan Profil</span>
                                    </a>
                                </div>

                                {{-- Logout Action --}}
                                <div class="p-1.5">
                                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold text-rose-600 hover:bg-rose-50 transition-colors">
                                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            <span>Keluar (Logout Akun)</span>
                                        </button>
                                    </form>
                                </div>
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
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-white border border-slate-200 flex-shrink-0 flex items-center justify-center">
                            <img src="{{ asset('images/logo-smecone.png') }}" alt="Logo SMECONE" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <span class="text-base font-black text-slate-900 tracking-tight">SMECONE E-KANTIN</span>
                            <p class="text-xs text-slate-500 font-medium">SMK Negeri 1 Purwokerto</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed max-w-md">
                        Platform pemesanan makanan mandiri untuk lingkungan SMK Negeri 1 Purwokerto. 
                        Pre-order sebelum bel istirahat, bayar digital via Midtrans QRIS, dan ambil cepat tanpa antre.
                    </p>
                    <p class="text-[11px] text-slate-400 flex items-start gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Jl. Dr. Soeparno No. 29, Purwokerto Wetan, Kec. Purwokerto Timur, Kab. Banyumas, Jawa Tengah 53111</span>
                    </p>
                </div>

                {{-- Col 2: Zona Kantin --}}
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-3">Zona Kantin</h4>
                    <ul class="space-y-2 text-xs text-slate-600 font-medium">
                        <li>&bull; Kantin Pemasaran (Depan)</li>
                        <li>&bull; Kantin Corner</li>
                        <li>&bull; Kantin Belakang</li>
                    </ul>
                </div>

                {{-- Col 3: Jadwal Istirahat --}}
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-3">Sesi Istirahat</h4>
                    <ul class="space-y-2 text-xs text-slate-600 font-medium">
                        <li class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            <span><strong>Istirahat 1:</strong> 09:45 - 10:15 WIB</span>
                        </li>
                        <li class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            <span><strong>Istirahat 2:</strong> 12:00 - 12:45 WIB</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-2">
                <p>&copy; {{ date('Y') }} SMK Negeri 1 Purwokerto &bull; Hak Cipta Dilindungi.</p>
                <p class="font-medium">Full Cashless via Midtrans QRIS &bull; Real-Time WebSockets</p>
            </div>
        </div>
    </footer>

    {{-- Fallback Vanilla JS Script for Guaranteed Dropdown Operation --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('user-menu-btn');
            const menu = document.getElementById('user-dropdown-menu');

            if (btn && menu) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isHidden = menu.style.display === 'none' || menu.classList.contains('hidden');
                    if (isHidden) {
                        menu.style.display = 'block';
                        menu.classList.remove('hidden');
                    } else {
                        menu.style.display = 'none';
                        menu.classList.add('hidden');
                    }
                });

                document.addEventListener('click', function(e) {
                    if (!menu.contains(e.target) && !btn.contains(e.target)) {
                        menu.style.display = 'none';
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
