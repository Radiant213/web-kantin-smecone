@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    {{-- ═══ Campus Hero Bento ═══ --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-primary-950 via-primary-900 to-primary-800 text-white">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 md:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                {{-- Left Text Banner --}}
                <div class="lg:col-span-7 space-y-5">
                    <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md rounded-full px-3.5 py-1.5 border border-white/15">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-xs font-semibold text-white/90 tracking-wide">Kantin Buka • Pre-Order Siap</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight tracking-tight">
                        Jajan Tenang, <br>
                        <span class="text-amber-400">Tepat Saat Bel Berdentang.</span>
                    </h1>

                    <p class="text-sm sm:text-base text-slate-200 max-w-xl leading-relaxed">
                        Pesan makanan favoritmu dari kelas sebelum jam istirahat. Begitu bel berbunyi, langsung ambil di loket baki kios tanpa perlu desak-desakan mengantre.
                    </p>

                    {{-- Time Slot Pills --}}
                    <div class="flex flex-wrap gap-2.5 pt-1">
                        <div class="flex items-center gap-2 bg-black/20 backdrop-blur-sm border border-white/10 px-3.5 py-2 rounded-xl text-xs">
                            <span class="text-amber-400 font-bold">Istirahat 1:</span>
                            <span class="text-slate-200 font-medium">09:45 - 10:15 WIB</span>
                        </div>
                        <div class="flex items-center gap-2 bg-black/20 backdrop-blur-sm border border-white/10 px-3.5 py-2 rounded-xl text-xs">
                            <span class="text-amber-400 font-bold">Istirahat 2:</span>
                            <span class="text-slate-200 font-medium">12:00 - 12:45 WIB</span>
                        </div>
                    </div>

                    {{-- CTAs --}}
                    <div class="flex flex-wrap items-center gap-3 pt-3">
                        <a href="#zona-kantin" 
                           class="inline-flex items-center gap-2 bg-amber-400 hover:bg-amber-300 text-slate-900 font-bold px-6 py-3 rounded-xl transition-all shadow-md hover:scale-[1.02]">
                            <span>Pilih Kantin</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </a>
                        <div class="inline-flex items-center gap-2 px-4 py-3 rounded-xl bg-white/10 backdrop-blur-sm border border-white/15 text-xs text-white/90 font-medium">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Full Cashless • QRIS Midtrans</span>
                        </div>
                    </div>
                </div>

                {{-- Right Bento Card: Quick Info --}}
                <div class="lg:col-span-5">
                    <div class="bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl p-6 space-y-4 shadow-xl">
                        <div class="flex items-center justify-between pb-3 border-b border-white/10">
                            <div>
                                <h3 class="text-sm font-bold text-white">Status Layanan Digital</h3>
                                <p class="text-xs text-slate-300">SMK Negeri 1 Purwokerto</p>
                            </div>
                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                                Real-Time Aktif
                            </span>
                        </div>

                        <div class="space-y-2.5 text-xs">
                            <div class="flex items-center justify-between bg-black/20 p-3 rounded-xl">
                                <span class="text-slate-300">Estimasi Masak</span>
                                <span class="font-bold text-white">⚡ 5 - 10 Menit</span>
                            </div>
                            <div class="flex items-center justify-between bg-black/20 p-3 rounded-xl">
                                <span class="text-slate-300">Notifikasi Siap Ambil</span>
                                <span class="font-bold text-emerald-300">🔔 Web Push & Suara</span>
                            </div>
                            <div class="flex items-center justify-between bg-black/20 p-3 rounded-xl">
                                <span class="text-slate-300">Pengambilan Pesanan</span>
                                <span class="font-bold text-white">Cukup Tunjukkan Nota Digital</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══ 3 Zona Kantin Riil SMECONE ═══ --}}
    <section id="zona-kantin" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="inline-block text-xs font-bold uppercase tracking-wider text-primary-800 bg-primary-50 px-3 py-1 rounded-full mb-2">
                Zona Kampus SMECONE
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Pilih Zona Kantin</h2>
            <p class="text-sm text-slate-500 mt-2">
                Pilih kantin terdekat dengan ruang kelas atau ruang praktikum Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($kantins as $kantin)
                <a href="{{ route('kantin.show', $kantin) }}" 
                   class="group card p-6 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-primary-50 text-primary-800 flex items-center justify-center font-bold text-lg group-hover:bg-primary-800 group-hover:text-white transition-colors">
                                @if(str_contains(strtolower($kantin->name), 'pemasaran'))
                                    🏬
                                @elseif(str_contains(strtolower($kantin->name), 'corner'))
                                    ☕
                                @else
                                    🍲
                                @endif
                            </div>
                            <span class="badge-success text-xs font-bold">
                                {{ $kantin->kiosks_count }} Kios Buka
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary-800 transition-colors">
                            {{ $kantin->name }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            {{ $kantin->description ?? 'Jelajahi berbagai pilihan menu makanan dan minuman lezat di kantin ini.' }}
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-primary-800">
                        <span>Lihat Kios & Menu</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ═══ 4 Pilar Keunggulan (Value Proposition) ═══ --}}
    <section class="bg-white border-y border-slate-200/80 py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-10">
                <h3 class="text-xl font-extrabold text-slate-900">Kenapa Pesan Lewat SMECONE E-Kantin?</h3>
                <p class="text-xs text-slate-500 mt-1">Dibuat khusus untuk efisiensi waktu istirahat warga SMK Negeri 1 Purwokerto.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Pillar 1 --}}
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2.5">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold">
                        ⏰
                    </div>
                    <h4 class="text-sm font-bold text-slate-900">Pre-Order Jam Istirahat</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pesan dari kelas 15 menit sebelum bel berbunyi. Makanan sudah siap matang saat waktu istirahat dimulai.
                    </p>
                </div>

                {{-- Pillar 2 --}}
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2.5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold">
                        🔔
                    </div>
                    <h4 class="text-sm font-bold text-slate-900">Notifikasi Web Push & Suara</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Layar HP otomatis bergetar dan membunyikan alarm saat pesanan selesai dimasak. Tak perlu berdiri menunggu di depan wajan.
                    </p>
                </div>

                {{-- Pillar 3 --}}
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2.5">
                    <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-800 flex items-center justify-center font-bold">
                        💳
                    </div>
                    <h4 class="text-sm font-bold text-slate-900">Full Cashless (QRIS)</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Bayar instan via QRIS Midtrans. Penjual fokus memasak higienis tanpa harus memegang uang tunai berminyak.
                    </p>
                </div>

                {{-- Pillar 4 --}}
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2.5">
                    <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-800 flex items-center justify-center font-bold">
                        📋
                    </div>
                    <h4 class="text-sm font-bold text-slate-900">Struk Digital Simpel</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Cukup tunjukkan nomor order dan nama di layar HP ke penjual kios. Cepat, jelas, dan tanpa ribet scan.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
