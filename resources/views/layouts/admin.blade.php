<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SMECONE') }} - Admin @yield('title')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-smecone.png') }}?v=3">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|poppins:400,500,600,700" rel="stylesheet" />

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-800"
    x-data="{
        sidebarOpen: false,
        rightPanelOpen: false,
        loaded: false
    }"
    x-init="setTimeout(() => loaded = true, 50)">
    <div class="flex min-h-screen">

        {{-- ═══ Sidebar Mobile Overlay ═══ --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden"
            style="display: none;"
            x-cloak></div>

        {{-- ═══ Sidebar (Left Column) ═══ --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200/80 shadow-xl lg:shadow-none transform transition-transform duration-300 lg:translate-x-0 lg:static flex flex-col flex-shrink-0">

            {{-- Logo SMECONE --}}
            <div class="flex items-center gap-3 px-5 h-16 border-b border-slate-100 flex-shrink-0 bg-white">
                <img src="{{ asset('images/logo-smecone.png') }}" alt="Logo SMECONE"
                    class="w-10 h-10 object-contain rounded-full shadow-sm border border-red-100 flex-shrink-0">
                <div class="flex flex-col min-w-0">
                    <span class="text-base font-extrabold text-slate-900 tracking-tight leading-none">SMECONE</span>
                    <span class="text-[10px] font-bold text-red-700 tracking-wider uppercase mt-1">E-Kantin Admin</span>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">Menu Utama</p>

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                          {{ request()->routeIs('admin.dashboard') ? 'bg-red-50 text-red-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-red-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Overview
                </a>

                <a href="{{ route('admin.kantins.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                          {{ request()->routeIs('admin.kantins.*') ? 'bg-red-50 text-red-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.kantins.*') ? 'text-red-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Kantin
                </a>

                <a href="{{ route('admin.kiosks.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                          {{ request()->routeIs('admin.kiosks.*') ? 'bg-red-50 text-red-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.kiosks.*') ? 'text-red-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h18v18H3zM12 8v4m0 4h.01" />
                    </svg>
                    Kiosks (Stand)
                </a>

                <a href="{{ route('admin.kiosk-applications.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                          {{ request()->routeIs('admin.kiosk-applications.*') ? 'bg-red-50 text-red-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.kiosk-applications.*') ? 'text-red-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Pengajuan Kios
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                          {{ request()->routeIs('admin.users.*') ? 'bg-red-50 text-red-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-red-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Users
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                          {{ request()->routeIs('admin.orders.*') ? 'bg-red-50 text-red-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.orders.*') ? 'text-red-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Pesanan (Orders)
                </a>

                <div class="pt-4 mt-4 border-t border-slate-100">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">Tautan Luar</p>
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all duration-200">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Ke Halaman Siswa
                    </a>
                </div>
            </nav>

            {{-- User Info (Bottom Sidebar) --}}
            <div class="px-4 py-3.5 border-t border-slate-100 flex-shrink-0 bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-red-100 text-red-800 flex items-center justify-center font-bold text-sm shadow-inner flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-red-700 font-semibold uppercase">Administrator</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Keluar" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- ═══ Center Main Content Area ═══ --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Top Header (Clean Z-Index 30) --}}
            <header
                class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200/80 h-16 flex items-center justify-between px-4 lg:px-8 gap-4">
                {{-- Mobile toggle --}}
                <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-600 hover:text-red-700 hover:bg-slate-100 rounded-xl mr-1 cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                {{-- Search (Left side) --}}
                <div class="flex-1 max-w-md">
                    <form action="{{ route('admin.search') }}" method="GET" class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Cari kantin, kios, atau user... (tekan enter)"
                            class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all placeholder:text-slate-400">
                    </form>
                </div>

                {{-- Right Actions (Pushed to far right via ml-auto) --}}
                <div class="ml-auto flex items-center gap-2 sm:gap-3">

                    {{-- Toggle Right Panel (Aktivitas & Info) --}}
                    <button @click.stop="rightPanelOpen = !rightPanelOpen"
                        id="admin-panel-btn"
                        type="button"
                        class="p-2 text-slate-500 hover:text-red-700 hover:bg-slate-100 rounded-xl transition-all cursor-pointer"
                        :class="rightPanelOpen ? 'bg-red-50 text-red-700 ring-1 ring-red-200' : ''"
                        title="Buka / Tutup Panel Informasi">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>

                    {{-- Notification Dropdown --}}
                    <div class="relative" x-data="{ notifOpen: false }">
                        <button @click.stop="notifOpen = !notifOpen"
                            id="admin-notif-btn"
                            type="button"
                            class="relative p-2 text-slate-500 hover:text-red-700 hover:bg-slate-100 rounded-xl transition-all cursor-pointer focus:outline-none"
                            :class="notifOpen ? 'bg-red-50 text-red-700' : ''"
                            title="Notifikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-600 rounded-full ring-2 ring-white"></span>
                        </button>

                        {{-- Dropdown card --}}
                        <div x-show="notifOpen"
                            @click.outside="notifOpen = false"
                            id="admin-notif-menu"
                            data-admin-dropdown
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                            class="absolute right-0 mt-2.5 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-200/90 py-2 z-[999] ring-1 ring-slate-900/5 overflow-hidden"
                            style="display: none;"
                            x-cloak>
                            <div class="px-4 py-2.5 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                                <div class="flex items-center gap-2">
                                    <span class="font-extrabold text-xs uppercase tracking-wider text-slate-800">Notifikasi Sistem</span>
                                </div>
                                <button type="button" @click="notifOpen = false" class="text-xs text-slate-400 hover:text-slate-600 cursor-pointer">✕</button>
                            </div>
                            <div class="max-h-72 overflow-y-auto divide-y divide-slate-100">
                                @php
                                    $recentNotifs = auth()->user()->unreadNotifications()->latest()->take(5)->get();
                                @endphp
                                @forelse($recentNotifs as $notif)
                                    <div class="p-3.5 hover:bg-slate-50 flex items-start gap-3 transition-colors">
                                        <div class="w-8 h-8 rounded-lg bg-red-50 text-red-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-semibold text-slate-800">{{ $notif->data['title'] ?? 'Notifikasi' }}</p>
                                            <p class="text-xs text-slate-600 mt-0.5">{{ $notif->data['message'] ?? 'Pemberitahuan baru' }}</p>
                                            <span class="text-[10px] text-slate-400 mt-1 block">{{ $notif->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-6 text-center text-slate-400 text-xs">
                                        <svg class="w-7 h-7 mx-auto text-slate-300 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                        Belum ada notifikasi baru.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Administrator Profile Dropdown (Same Rock-Solid Pattern as app.blade.php) --}}
                    <div class="relative" x-data="{ userDropdown: false }">
                        <button @click.stop="userDropdown = !userDropdown"
                            id="admin-user-btn"
                            type="button"
                            class="flex items-center gap-2.5 pl-2 pr-3 py-1.5 rounded-full border border-slate-200/90 hover:border-red-200 hover:bg-slate-50 transition-all focus:outline-none focus:ring-2 focus:ring-red-500/20 cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-red-100 text-red-800 flex items-center justify-center font-bold text-xs shadow-inner">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden sm:flex flex-col text-left">
                                <span class="text-xs font-bold text-slate-800 leading-tight">{{ auth()->user()->name }}</span>
                                <span class="text-[10px] text-slate-400 leading-none">Admin</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                                :class="userDropdown ? 'rotate-180' : ''"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="userDropdown"
                            @click.outside="userDropdown = false"
                            id="admin-user-menu"
                            data-admin-dropdown
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                            class="absolute right-0 mt-2.5 w-60 rounded-2xl shadow-2xl bg-white border border-slate-200/90 py-2 z-[999] ring-1 ring-slate-900/5 divide-y divide-slate-100"
                            style="display: none;"
                            x-cloak>

                            {{-- User Identity Header --}}
                            <div class="px-4 py-3 bg-slate-50/70 -mt-2 rounded-t-2xl border-b border-slate-100">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Akun Terdaftar</p>
                                <p class="text-sm font-extrabold text-slate-900 truncate mt-0.5">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                                <span class="inline-block mt-1.5 text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-red-100 text-red-700">
                                    Administrator
                                </span>
                            </div>

                            {{-- Actions --}}
                            <div class="py-1.5 space-y-0.5 px-1.5">
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 hover:text-red-700 transition-colors">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Pengaturan Profil
                                </a>
                                <a href="{{ route('home') }}"
                                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 hover:text-red-700 transition-colors">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                    Ke Halaman Siswa
                                </a>
                            </div>

                            {{-- Logout Action --}}
                            <div class="p-1.5">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold text-red-600 hover:bg-red-50 transition-colors cursor-pointer">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                        Keluar (Logout)
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
                    class="mx-4 lg:mx-8 mt-4 bg-emerald-50 text-emerald-800 px-4 py-3 rounded-2xl text-sm font-semibold border border-emerald-200 flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-800 text-xs">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
                    class="mx-4 lg:mx-8 mt-4 bg-rose-50 text-rose-800 px-4 py-3 rounded-2xl text-sm font-semibold border border-rose-200 flex items-center justify-between">
                    <span>{{ session('error') }}</span>
                    <button @click="show = false" class="text-rose-500 hover:text-rose-800 text-xs">✕</button>
                </div>
            @endif

            {{-- Page Content --}}
            <main class="flex-1 p-4 lg:p-8 transition-all duration-500 ease-out transform"
                :class="loaded ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'">
                @yield('content')
            </main>
        </div>

        {{-- ═══ Desktop Right Panel (Flex sibling column, NOT fixed, perfectly non-overlapping) ═══ --}}
        <aside x-show="rightPanelOpen"
            id="admin-right-panel-desktop"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-x-4"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-4"
            class="hidden xl:flex flex-col w-80 bg-white border-l border-slate-200/80 p-5 overflow-y-auto flex-shrink-0"
            style="display: none;">

            {{-- Panel Header with Close Button --}}
            <div class="flex items-center justify-between pb-3.5 mb-5 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                    <h3 class="font-bold text-sm text-slate-800">Panel Informasi</h3>
                </div>
                <button @click="rightPanelOpen = false"
                    type="button"
                    class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer"
                    title="Tutup Panel">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            @yield('right-panel')

            @if(!View::hasSection('right-panel'))
                @php
                    $panelNotifications = auth()->user()->unreadNotifications()->latest()->take(5)->get();
                    $panelActivities = \App\Models\ActivityLog::with('user')->latest()->take(6)->get();
                @endphp

                {{-- Notifikasi Section --}}
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Notifikasi</h4>
                        @if($panelNotifications->count() > 0)
                            <span class="px-2 py-0.5 rounded-full bg-red-50 text-red-700 text-[10px] font-bold">{{ $panelNotifications->count() }} baru</span>
                        @endif
                    </div>
                    <div class="space-y-2.5">
                        @forelse($panelNotifications as $notification)
                            <div class="flex items-start gap-2.5 p-2 rounded-xl hover:bg-slate-50 transition-colors">
                                <div class="w-7 h-7 rounded-lg bg-red-50 text-red-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-slate-800 leading-snug">
                                        {{ $notification->data['message'] ?? 'Notifikasi baru' }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic py-2">Belum ada notifikasi baru.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Aktivitas Section --}}
                <div>
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Aktivitas Terakhir</h4>
                    <div class="space-y-3">
                        @forelse($panelActivities as $activity)
                            <div class="flex items-start gap-2.5">
                                <div class="w-2 h-2 rounded-full bg-red-600 mt-1.5 flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-slate-700 leading-snug">
                                        @if($activity->user)
                                            <span class="font-bold text-slate-900">{{ $activity->user->name }}</span>
                                        @endif
                                        {{ $activity->description }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $activity->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic py-2">Belum ada aktivitas tercatat.</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </aside>

        {{-- ═══ Mobile Drawer (Only shown when rightPanelOpen on < xl screens) ═══ --}}
        <div x-show="rightPanelOpen"
            id="admin-right-panel-mobile"
            class="relative z-50 xl:hidden"
            style="display: none;"
            x-cloak>
            {{-- Mobile Backdrop --}}
            <div x-show="rightPanelOpen"
                @click="rightPanelOpen = false"
                x-transition:enter="transition-opacity ease-linear duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

            {{-- Mobile Drawer Content --}}
            <div class="fixed inset-y-0 right-0 w-80 bg-white shadow-2xl p-5 overflow-y-auto flex flex-col">
                <div class="flex items-center justify-between pb-3.5 mb-5 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                        <h3 class="font-bold text-sm text-slate-800">Panel Informasi</h3>
                    </div>
                    <button @click="rightPanelOpen = false"
                        type="button"
                        class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer"
                        title="Tutup Panel">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                {{-- Same content for mobile --}}
                <div class="mb-6">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Notifikasi</h4>
                    <div class="space-y-2.5">
                        @forelse(auth()->user()->unreadNotifications()->latest()->take(5)->get() as $notification)
                            <div class="p-2 rounded-xl bg-slate-50 text-xs">
                                <p class="font-semibold text-slate-800">{{ $notification->data['message'] ?? 'Notifikasi baru' }}</p>
                                <span class="text-[10px] text-slate-400 mt-1 block">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic">Belum ada notifikasi baru.</p>
                        @endforelse
                    </div>
                </div>

                <div>
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Aktivitas Terakhir</h4>
                    <div class="space-y-2.5">
                        @forelse(\App\Models\ActivityLog::with('user')->latest()->take(5)->get() as $activity)
                            <div class="p-2 rounded-xl bg-slate-50 text-xs">
                                <p class="text-slate-700">
                                    @if($activity->user)<strong class="text-slate-900">{{ $activity->user->name }}:</strong>@endif
                                    {{ $activity->description }}
                                </p>
                                <span class="text-[10px] text-slate-400 mt-1 block">{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic">Belum ada aktivitas tercatat.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Fallback Vanilla JS for 100% Guaranteed Dropdown & Toggle Operations --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function setupDropdown(btnId, menuId) {
                const btn = document.getElementById(btnId);
                const menu = document.getElementById(menuId);
                if (!btn || !menu) return;

                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isHidden = menu.style.display === 'none' || menu.classList.contains('hidden');
                    // Close other admin dropdowns
                    document.querySelectorAll('[data-admin-dropdown]').forEach(function(d) {
                        if (d !== menu) d.style.display = 'none';
                    });
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

            // Bind User Profile and Notification dropdowns
            setupDropdown('admin-user-btn', 'admin-user-menu');
            setupDropdown('admin-notif-btn', 'admin-notif-menu');

            // Bind Right Panel toggle button for desktop/mobile
            const panelBtn = document.getElementById('admin-panel-btn');
            const rightPanelDesktop = document.getElementById('admin-right-panel-desktop');
            const rightPanelMobile = document.getElementById('admin-right-panel-mobile');

            if (panelBtn) {
                panelBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isDesktop = window.innerWidth >= 1280;
                    const target = isDesktop ? rightPanelDesktop : rightPanelMobile;
                    if (target) {
                        const isHidden = target.style.display === 'none' || target.classList.contains('hidden');
                        target.style.display = isHidden ? (isDesktop ? 'flex' : 'block') : 'none';
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
