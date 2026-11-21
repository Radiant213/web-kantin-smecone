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
                    @php
                        $lowerName = strtolower($menu->name);
                        $isCimol = str_contains($lowerName, 'cimol');
                        $isSeblak = str_contains($lowerName, 'seblak') && !str_contains($lowerName, 'kering');
                    @endphp
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
                                @if($isCimol)
                                    <span class="bg-amber-400 text-slate-900 text-[11px] font-extrabold px-2.5 py-1 rounded-lg shadow-sm">
                                        Bebas Request Porsi
                                    </span>
                                @elseif($isSeblak)
                                    <span class="bg-rose-500 text-white text-[11px] font-extrabold px-2.5 py-1 rounded-lg shadow-sm">
                                        Bisa Pilih Topping
                                    </span>
                                @else
                                    <span class="bg-white/95 backdrop-blur-sm text-slate-800 text-[11px] font-bold px-2.5 py-1 rounded-lg shadow-sm border border-slate-100">
                                        Fresh Cooked
                                    </span>
                                @endif
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
                                    @if($isCimol)
                                        <p class="text-[10px] uppercase font-bold text-amber-600 tracking-wider">Fleksibel</p>
                                        <p class="text-base sm:text-lg font-extrabold text-amber-700">
                                            Mulai Rp 2.000
                                        </p>
                                    @elseif($isSeblak)
                                        <p class="text-[10px] uppercase font-bold text-rose-600 tracking-wider">Custom Topping</p>
                                        <p class="text-base sm:text-lg font-extrabold text-rose-700">
                                            Mulai Rp 5.000
                                        </p>
                                    @else
                                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Harga</p>
                                        <p class="text-lg font-extrabold text-primary-700">
                                            {{ $menu->formattedPrice() }}
                                        </p>
                                    @endif
                                </div>

                                @auth
                                    @if($isCimol)
                                        <button type="button"
                                            onclick="openCimolModal({{ $menu->id }}, '{{ addslashes($menu->name) }}', {{ $menu->price }})"
                                            class="inline-flex items-center gap-1.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 active:scale-95 text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition-all shadow-sm shadow-amber-500/20">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                                            Atur Porsi
                                        </button>
                                    @elseif($isSeblak)
                                        <button type="button"
                                            onclick="openSeblakModal({{ $menu->id }}, '{{ addslashes($menu->name) }}', {{ $menu->price }})"
                                            class="inline-flex items-center gap-1.5 bg-gradient-to-r from-rose-600 to-rose-700 hover:from-rose-700 hover:to-rose-800 active:scale-95 text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition-all shadow-sm shadow-rose-600/20">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                                            Racik Topping
                                        </button>
                                    @else
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
                                    @endif
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

    {{-- ═══ Modal Kustomisasi Cimol ═══ --}}
    <div id="cimolModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="relative bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all my-8">
            {{-- Modal Header --}}
            <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-5 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center font-black text-lg">
                        🍡
                    </div>
                    <div>
                        <h3 class="font-extrabold text-base leading-tight" id="cimolModalTitle">Kustomisasi Porsi Cimol</h3>
                        <p class="text-[11px] text-amber-100 mt-0.5">Mulai Rp 2.000 &bull; Kelipatan Rp 1.000</p>
                    </div>
                </div>
                <button type="button" onclick="closeCimolModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Modal Form --}}
            <form method="POST" action="{{ route('cart.add') }}" class="p-6 space-y-5" onsubmit="return submitCimolForm(this)">
                @csrf
                <input type="hidden" name="menu_id" id="cimolMenuId" value="">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="custom_price" id="cimolFinalPrice" value="2000">
                <input type="hidden" name="notes" id="cimolFinalNotes" value="">

                {{-- Nominal Porsi --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        1. Tentukan Nominal Porsi (Rp):
                    </label>
                    <div class="grid grid-cols-3 gap-2 mb-3">
                        <button type="button" onclick="selectCimolPrice(2000)" class="cimol-price-btn py-2 px-3 rounded-xl border text-xs font-bold transition-all border-amber-500 bg-amber-50 text-amber-900 ring-1 ring-amber-400" data-price="2000">Rp 2.000</button>
                        <button type="button" onclick="selectCimolPrice(3000)" class="cimol-price-btn py-2 px-3 rounded-xl border text-xs font-bold transition-all border-slate-200 hover:bg-slate-50 text-slate-700" data-price="3000">Rp 3.000</button>
                        <button type="button" onclick="selectCimolPrice(4000)" class="cimol-price-btn py-2 px-3 rounded-xl border text-xs font-bold transition-all border-slate-200 hover:bg-slate-50 text-slate-700" data-price="4000">Rp 4.000</button>
                        <button type="button" onclick="selectCimolPrice(5000)" class="cimol-price-btn py-2 px-3 rounded-xl border text-xs font-bold transition-all border-slate-200 hover:bg-slate-50 text-slate-700" data-price="5000">Rp 5.000</button>
                        <button type="button" onclick="selectCimolPrice(7000)" class="cimol-price-btn py-2 px-3 rounded-xl border text-xs font-bold transition-all border-slate-200 hover:bg-slate-50 text-slate-700" data-price="7000">Rp 7.000</button>
                        <button type="button" onclick="selectCimolPrice(10000)" class="cimol-price-btn py-2 px-3 rounded-xl border text-xs font-bold transition-all border-slate-200 hover:bg-slate-50 text-slate-700" data-price="10000">Rp 10.000</button>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-bold text-slate-400">Rp</span>
                        <input type="number" id="cimolCustomInput" min="2000" step="1000" value="2000" oninput="onCimolCustomInput(this.value)" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-800 focus:border-amber-500 focus:ring-1 focus:ring-amber-500" placeholder="Ketik nominal kustom...">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Harus kelipatan Rp 1.000 (contoh: 2000, 3000, 5000, 6000).</p>
                </div>

                {{-- Bumbu Tabur --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        2. Pilih Bumbu Tabur (Boleh Campur):
                    </label>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer has-[:checked]:bg-amber-50 has-[:checked]:border-amber-400">
                            <input type="checkbox" value="Balado Pedas Manis" class="cimol-seasoning text-amber-600 rounded focus:ring-amber-500" checked onchange="updateCimolSummary()">
                            <span class="font-semibold text-slate-800">Balado</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer has-[:checked]:bg-amber-50 has-[:checked]:border-amber-400">
                            <input type="checkbox" value="Asin / Gurih" class="cimol-seasoning text-amber-600 rounded focus:ring-amber-500" checked onchange="updateCimolSummary()">
                            <span class="font-semibold text-slate-800">Asin / Gurih</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer has-[:checked]:bg-amber-50 has-[:checked]:border-amber-400">
                            <input type="checkbox" value="Pedas Cabai Bubuk" class="cimol-seasoning text-amber-600 rounded focus:ring-amber-500" onchange="updateCimolSummary()">
                            <span class="font-semibold text-slate-800">Cabai Bubuk</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer has-[:checked]:bg-amber-50 has-[:checked]:border-amber-400">
                            <input type="checkbox" value="Keju Manis" class="cimol-seasoning text-amber-600 rounded focus:ring-amber-500" onchange="updateCimolSummary()">
                            <span class="font-semibold text-slate-800">Keju Manis</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer has-[:checked]:bg-amber-50 has-[:checked]:border-amber-400 col-span-2">
                            <input type="checkbox" value="Jagung Manis" class="cimol-seasoning text-amber-600 rounded focus:ring-amber-500" onchange="updateCimolSummary()">
                            <span class="font-semibold text-slate-800">Jagung Manis</span>
                        </label>
                    </div>
                </div>

                {{-- Catatan Khusus --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        3. Catatan Khusus (Opsional):
                    </label>
                    <input type="text" id="cimolExtraNote" placeholder="Contoh: bumbu dipisah, jangan terlalu pedas..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:border-amber-500 focus:ring-1 focus:ring-amber-500" oninput="updateCimolSummary()">
                </div>

                {{-- Total & Submit --}}
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Total Harga</span>
                        <span class="text-xl font-black text-amber-600" id="cimolDisplayTotal">Rp 2.000</span>
                    </div>
                    <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-extrabold text-xs px-5 py-3 rounded-2xl shadow-md shadow-amber-500/20 active:scale-95 transition-all">
                        <span>Masukkan Baki</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ═══ Modal Kustomisasi Seblak ═══ --}}
    <div id="seblakModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="relative bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all my-8">
            {{-- Modal Header --}}
            <div class="bg-gradient-to-r from-rose-600 to-rose-700 p-5 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center font-black text-lg">
                        🍲
                    </div>
                    <div>
                        <h3 class="font-extrabold text-base leading-tight" id="seblakModalTitle">Racik Seblak Bandung</h3>
                        <p class="text-[11px] text-rose-100 mt-0.5">Dasar Rp 5.000 (Kerupuk basah + bumbu kencur gurih)</p>
                    </div>
                </div>
                <button type="button" onclick="closeSeblakModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Modal Form --}}
            <form method="POST" action="{{ route('cart.add') }}" class="p-6 space-y-5" onsubmit="return submitSeblakForm(this)">
                @csrf
                <input type="hidden" name="menu_id" id="seblakMenuId" value="">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="custom_price" id="seblakFinalPrice" value="5000">
                <input type="hidden" name="notes" id="seblakFinalNotes" value="">

                {{-- 1. Level Pedas --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        1. Pilih Level Pedas:
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                        <label class="flex flex-col items-center justify-center p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer text-center has-[:checked]:bg-rose-50 has-[:checked]:border-rose-500 has-[:checked]:text-rose-900">
                            <input type="radio" name="seblak_level" value="Level 0 (Gurih Tidak Pedas)" class="sr-only" onchange="updateSeblakTotal()">
                            <span class="font-bold">Level 0</span>
                            <span class="text-[10px] text-slate-400 mt-0.5">Gurih/Ori</span>
                        </label>
                        <label class="flex flex-col items-center justify-center p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer text-center has-[:checked]:bg-rose-50 has-[:checked]:border-rose-500 has-[:checked]:text-rose-900">
                            <input type="radio" name="seblak_level" value="Level 1 (Pedas Sedang)" checked class="sr-only" onchange="updateSeblakTotal()">
                            <span class="font-bold text-rose-600">Level 1 🌶️</span>
                            <span class="text-[10px] text-slate-400 mt-0.5">Sedang</span>
                        </label>
                        <label class="flex flex-col items-center justify-center p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer text-center has-[:checked]:bg-rose-50 has-[:checked]:border-rose-500 has-[:checked]:text-rose-900">
                            <input type="radio" name="seblak_level" value="Level 2 (Pedas Nampol)" class="sr-only" onchange="updateSeblakTotal()">
                            <span class="font-bold text-rose-700">Level 2 🌶️🌶️</span>
                            <span class="text-[10px] text-slate-400 mt-0.5">Nampol</span>
                        </label>
                        <label class="flex flex-col items-center justify-center p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer text-center has-[:checked]:bg-rose-50 has-[:checked]:border-rose-500 has-[:checked]:text-rose-900">
                            <input type="radio" name="seblak_level" value="Level 3 (Ekstra Jebew)" class="sr-only" onchange="updateSeblakTotal()">
                            <span class="font-bold text-rose-900">Level 3 🔥</span>
                            <span class="text-[10px] text-slate-400 mt-0.5">Jebew</span>
                        </label>
                    </div>
                </div>

                {{-- 2. Topping Pilihan --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        2. Tambah Topping Favorit:
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                        <label class="flex items-center justify-between p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer has-[:checked]:bg-rose-50 has-[:checked]:border-rose-400">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" value="Mie Kuning" data-price="2000" class="seblak-topping text-rose-600 rounded focus:ring-rose-500" onchange="updateSeblakTotal()">
                                <span class="font-semibold text-slate-800">+ Mie Kuning</span>
                            </div>
                            <span class="font-bold text-slate-500">+Rp 2.000</span>
                        </label>
                        <label class="flex items-center justify-between p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer has-[:checked]:bg-rose-50 has-[:checked]:border-rose-400">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" value="Kwetiau" data-price="2000" class="seblak-topping text-rose-600 rounded focus:ring-rose-500" onchange="updateSeblakTotal()">
                                <span class="font-semibold text-slate-800">+ Kwetiau</span>
                            </div>
                            <span class="font-bold text-slate-500">+Rp 2.000</span>
                        </label>
                        <label class="flex items-center justify-between p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer has-[:checked]:bg-rose-50 has-[:checked]:border-rose-400">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" value="Makaroni" data-price="2000" class="seblak-topping text-rose-600 rounded focus:ring-rose-500" onchange="updateSeblakTotal()">
                                <span class="font-semibold text-slate-800">+ Makaroni</span>
                            </div>
                            <span class="font-bold text-slate-500">+Rp 2.000</span>
                        </label>
                        <label class="flex items-center justify-between p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer has-[:checked]:bg-rose-50 has-[:checked]:border-rose-400">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" value="Telur Kocok" data-price="3000" class="seblak-topping text-rose-600 rounded focus:ring-rose-500" onchange="updateSeblakTotal()">
                                <span class="font-semibold text-slate-800">+ Telur Kocok</span>
                            </div>
                            <span class="font-bold text-slate-500">+Rp 3.000</span>
                        </label>
                        <label class="flex items-center justify-between p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer has-[:checked]:bg-rose-50 has-[:checked]:border-rose-400">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" value="Sosis Sapi" data-price="2000" class="seblak-topping text-rose-600 rounded focus:ring-rose-500" onchange="updateSeblakTotal()">
                                <span class="font-semibold text-slate-800">+ Sosis Sapi</span>
                            </div>
                            <span class="font-bold text-slate-500">+Rp 2.000</span>
                        </label>
                        <label class="flex items-center justify-between p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer has-[:checked]:bg-rose-50 has-[:checked]:border-rose-400">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" value="Bakso Sapi" data-price="2000" class="seblak-topping text-rose-600 rounded focus:ring-rose-500" onchange="updateSeblakTotal()">
                                <span class="font-semibold text-slate-800">+ Bakso Sapi</span>
                            </div>
                            <span class="font-bold text-slate-500">+Rp 2.000</span>
                        </label>
                        <label class="flex items-center justify-between p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer has-[:checked]:bg-rose-50 has-[:checked]:border-rose-400 col-span-1 sm:col-span-2">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" value="Sayur Sawi" data-price="1000" class="seblak-topping text-rose-600 rounded focus:ring-rose-500" onchange="updateSeblakTotal()">
                                <span class="font-semibold text-slate-800">+ Sayur Sawi Hijau</span>
                            </div>
                            <span class="font-bold text-slate-500">+Rp 1.000</span>
                        </label>
                    </div>
                </div>

                {{-- 3. Catatan Khusus --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        3. Catatan Khusus (Opsional):
                    </label>
                    <input type="text" id="seblakExtraNote" placeholder="Contoh: kuah nyemek, kuah banjir, jangan daun bawang..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:border-rose-500 focus:ring-1 focus:ring-rose-500" oninput="updateSeblakTotal()">
                </div>

                {{-- Total & Submit --}}
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Total Harga</span>
                        <span class="text-xl font-black text-rose-600" id="seblakDisplayTotal">Rp 5.000</span>
                    </div>
                    <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-rose-600 to-rose-700 hover:from-rose-700 hover:to-rose-800 text-white font-extrabold text-xs px-5 py-3 rounded-2xl shadow-md shadow-rose-600/20 active:scale-95 transition-all">
                        <span>Masukkan Baki</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ═══ Cimol Modal Logic ═══
        let currentCimolPrice = 2000;
        function openCimolModal(menuId, menuName, basePrice) {
            document.getElementById('cimolMenuId').value = menuId;
            document.getElementById('cimolModalTitle').textContent = 'Kustomisasi: ' + menuName;
            selectCimolPrice(2000);
            document.getElementById('cimolExtraNote').value = '';
            document.getElementById('cimolModal').classList.remove('hidden');
        }
        function closeCimolModal() {
            document.getElementById('cimolModal').classList.add('hidden');
        }
        function selectCimolPrice(price) {
            currentCimolPrice = parseInt(price);
            document.getElementById('cimolCustomInput').value = currentCimolPrice;
            document.querySelectorAll('.cimol-price-btn').forEach(btn => {
                if (parseInt(btn.dataset.price) === currentCimolPrice) {
                    btn.className = 'cimol-price-btn py-2 px-3 rounded-xl border text-xs font-bold transition-all border-amber-500 bg-amber-50 text-amber-900 ring-1 ring-amber-400';
                } else {
                    btn.className = 'cimol-price-btn py-2 px-3 rounded-xl border text-xs font-bold transition-all border-slate-200 hover:bg-slate-50 text-slate-700';
                }
            });
            updateCimolSummary();
        }
        function onCimolCustomInput(val) {
            let p = parseInt(val) || 2000;
            if (p < 2000) p = 2000;
            currentCimolPrice = p;
            document.querySelectorAll('.cimol-price-btn').forEach(btn => {
                if (parseInt(btn.dataset.price) === currentCimolPrice) {
                    btn.className = 'cimol-price-btn py-2 px-3 rounded-xl border text-xs font-bold transition-all border-amber-500 bg-amber-50 text-amber-900 ring-1 ring-amber-400';
                } else {
                    btn.className = 'cimol-price-btn py-2 px-3 rounded-xl border text-xs font-bold transition-all border-slate-200 hover:bg-slate-50 text-slate-700';
                }
            });
            updateCimolSummary();
        }
        function updateCimolSummary() {
            document.getElementById('cimolFinalPrice').value = currentCimolPrice;
            document.getElementById('cimolDisplayTotal').textContent = 'Rp ' + currentCimolPrice.toLocaleString('id-ID');
            
            const seasonings = [];
            document.querySelectorAll('.cimol-seasoning:checked').forEach(cb => seasonings.push(cb.value));
            const extra = document.getElementById('cimolExtraNote').value.trim();
            
            let notesArr = [];
            notesArr.push('Porsi: Rp ' + currentCimolPrice.toLocaleString('id-ID'));
            if (seasonings.length > 0) {
                notesArr.push('Bumbu: ' + seasonings.join(', '));
            } else {
                notesArr.push('Bumbu: Polos');
            }
            if (extra) {
                notesArr.push('Catatan: ' + extra);
            }
            document.getElementById('cimolFinalNotes').value = notesArr.join(' | ');
        }
        function submitCimolForm(form) {
            const val = parseInt(document.getElementById('cimolCustomInput').value);
            if (isNaN(val) || val < 2000 || val % 1000 !== 0) {
                alert('Nominal porsi minimal Rp 2.000 dan harus kelipatan Rp 1.000!');
                return false;
            }
            updateCimolSummary();
            return true;
        }

        // ═══ Seblak Modal Logic ═══
        let baseSeblakPrice = 5000;
        function openSeblakModal(menuId, menuName, basePrice) {
            document.getElementById('seblakMenuId').value = menuId;
            document.getElementById('seblakModalTitle').textContent = 'Racik: ' + menuName;
            baseSeblakPrice = basePrice || 5000;
            document.querySelectorAll('.seblak-topping').forEach(cb => cb.checked = false);
            document.getElementById('seblakExtraNote').value = '';
            updateSeblakTotal();
            document.getElementById('seblakModal').classList.remove('hidden');
        }
        function closeSeblakModal() {
            document.getElementById('seblakModal').classList.add('hidden');
        }
        function updateSeblakTotal() {
            let total = baseSeblakPrice;
            const selectedToppings = [];
            document.querySelectorAll('.seblak-topping:checked').forEach(cb => {
                total += parseInt(cb.dataset.price);
                selectedToppings.push(cb.value);
            });

            const selectedLevel = document.querySelector('input[name="seblak_level"]:checked')?.value || 'Level 1 (Pedas Sedang)';
            const extra = document.getElementById('seblakExtraNote').value.trim();

            document.getElementById('seblakFinalPrice').value = total;
            document.getElementById('seblakDisplayTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');

            let notesArr = [selectedLevel];
            if (selectedToppings.length > 0) {
                notesArr.push('Topping: ' + selectedToppings.join(', '));
            } else {
                notesArr.push('Topping: Kerupuk Saja');
            }
            if (extra) {
                notesArr.push('Catatan: ' + extra);
            }
            document.getElementById('seblakFinalNotes').value = notesArr.join(' | ');
        }
        function submitSeblakForm(form) {
            updateSeblakTotal();
            return true;
        }

        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCimolModal();
                closeSeblakModal();
            }
        });
    </script>
@endsection
