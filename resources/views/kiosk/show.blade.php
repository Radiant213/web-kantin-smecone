@extends('layouts.app')

@section('title', $kiosk->name . ' - SMECONE E-Kantin')

@section('content')
    {{-- ═══ Kiosk Cover Banner ═══ --}}
    <div class="relative bg-gradient-to-r from-primary-950 via-primary-900 to-primary-800 text-white overflow-hidden py-10 lg:py-14 border-b border-primary-800/40">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-xs font-semibold text-primary-200/80 uppercase tracking-wider mb-4">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('kantin.show', $kiosk->kantin) }}" class="hover:text-white transition-colors">{{ $kiosk->kantin->name }}</a>
                <span>/</span>
                <span class="text-amber-300">{{ $kiosk->name }}</span>
            </div>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-start sm:items-center gap-4">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 p-2 flex items-center justify-center shrink-0 shadow-lg shadow-black/20">
                        @if($kiosk->image)
                            <img src="{{ asset('storage/' . $kiosk->image) }}" alt="{{ $kiosk->name }}" class="w-full h-full object-cover rounded-xl">
                        @else
                            <div class="w-full h-full rounded-xl bg-primary-800/60 flex items-center justify-center text-amber-300 font-extrabold text-2xl">
                                {{ strtoupper(substr($kiosk->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>

                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-400 text-primary-950">
                                Official Stand
                            </span>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/10 text-primary-100 border border-white/15">
                                {{ $kiosk->kantin->name }}
                            </span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white">
                            {{ $kiosk->name }}
                        </h1>
                        <p class="text-primary-200/90 text-sm mt-1 flex items-center gap-2">
                            <span>Pengelola: <strong class="text-white">{{ $kiosk->user->name }}</strong></span>
                            <span>•</span>
                            <span>{{ $kiosk->menus->count() }} Menu Aktif</span>
                        </p>
                    </div>
                </div>

                {{-- Quick Info Card --}}
                <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/15 px-4 py-3 rounded-2xl">
                    <div class="w-10 h-10 rounded-xl bg-amber-400/20 text-amber-300 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-xs">
                        <p class="text-primary-200 font-medium">Pengambilan Pesanan</p>
                        <p class="text-white font-bold text-sm">Istirahat 1 &amp; 2</p>
                    </div>
                </div>
            </div>

            @if($kiosk->description)
                <p class="mt-4 text-sm text-primary-100/80 max-w-2xl leading-relaxed">
                    {{ $kiosk->description }}
                </p>
            @endif
        </div>
    </div>

    {{-- ═══ Menu List ═══ --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-200">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Daftar Menu Siap Pesan</h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Pesan sekarang untuk diambil fresh saat jam istirahat sekolah</p>
            </div>
            <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-primary-50 text-primary-700 hover:bg-primary-100 font-semibold text-xs sm:text-sm transition-colors border border-primary-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                Lihat Keranjang
            </a>
        </div>

        @if($kiosk->menus->isEmpty())
            <div class="text-center py-20 bg-white rounded-3xl border border-slate-200 shadow-sm">
                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Menu Belum Tersedia</h3>
                <p class="text-sm text-slate-500 mt-1">Stand ini sedang mempersiapkan hidangan terbaik mereka.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($kiosk->menus as $menu)
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col group">
                        {{-- Image / Placeholder --}}
                        <div class="relative h-48 bg-slate-100 overflow-hidden">
                            @if($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-slate-400">
                                    <svg class="w-10 h-10 mb-1 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs font-medium">SMECONE Kitchen</span>
                                </div>
                            @endif

                            <div class="absolute top-3 left-3">
                                <span class="bg-white/95 backdrop-blur-sm text-slate-800 text-[11px] font-bold px-2.5 py-1 rounded-lg shadow-sm border border-slate-100">
                                    Fresh Cooked
                                </span>
                            </div>
                        </div>

                        {{-- Body --}}
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-slate-900 text-base group-hover:text-primary-700 transition-colors">
                                {{ $menu->name }}
                            </h3>
                            
                            @if($menu->description)
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                    {{ $menu->description }}
                                </p>
                            @else
                                <p class="text-xs text-slate-400 mt-1 italic">
                                    Pilihan menu lezat dan higienis dari {{ $kiosk->name }}.
                                </p>
                            @endif

                            <div class="mt-auto pt-4 flex items-center justify-between border-t border-slate-100">
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Harga</p>
                                    <p class="text-lg font-extrabold text-primary-700">
                                        {{ $menu->formattedPrice() }}
                                    </p>
                                </div>

                                @auth
                                    <form method="POST" action="{{ route('cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                            class="inline-flex items-center gap-1.5 bg-primary-700 hover:bg-primary-800 active:bg-primary-900 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-sm shadow-primary-700/20 active:scale-95">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Tambah
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="inline-flex items-center gap-1.5 bg-primary-700 hover:bg-primary-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-sm">
                                        Pesan
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
