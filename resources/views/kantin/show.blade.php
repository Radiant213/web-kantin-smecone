@extends('layouts.app')

@section('title', $kantin->name . ' - SMECONE E-Kantin')

@section('content')
    {{-- ═══ Header ═══ --}}
    <div class="bg-gradient-to-r from-primary-950 via-primary-900 to-primary-800 text-white py-10 lg:py-12 border-b border-primary-800/40 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="flex items-center justify-center w-11 h-11 rounded-2xl bg-white/10 hover:bg-white/20 text-white transition-all border border-white/15">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-400 text-primary-950">Zona Kantin Resmi</span>
                        <span class="text-xs text-primary-200">SMK Negeri 1 Purwokerto</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">{{ $kantin->name }}</h1>
                    <p class="text-sm text-primary-200 mt-0.5">{{ $kantin->kiosks->count() }} kios aktif melayani pemesanan</p>
                </div>
            </div>

            @if($kantin->description)
                <p class="mt-4 text-sm text-primary-100/80 max-w-2xl leading-relaxed">
                    {{ $kantin->description }}
                </p>
            @endif
        </div>
    </div>

    {{-- ═══ Kios Grid ═══ --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-200">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Pilih Kios / Stand</h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Pilih kios favoritmu dan pesan makanan tanpa antre panjang</p>
            </div>
        </div>

        @if($kantin->kiosks->isEmpty())
            <div class="text-center py-20 bg-white rounded-3xl border border-slate-200 shadow-sm">
                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Belum Ada Kios Terdaftar</h3>
                <p class="text-sm text-slate-500 mt-1">Stand di zona ini sedang dalam tahap persiapan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($kantin->kiosks as $kiosk)
                    <a href="{{ route('kiosk.show', $kiosk) }}" class="group bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col">
                        {{-- Image --}}
                        <div class="relative h-44 bg-gradient-to-br from-primary-900 to-primary-700 overflow-hidden">
                            @if($kiosk->image)
                                <img src="{{ asset('storage/' . $kiosk->image) }}" alt="{{ $kiosk->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-amber-300 font-extrabold text-3xl">
                                    {{ strtoupper(substr($kiosk->name, 0, 2)) }}
                                </div>
                            @endif
                            <div class="absolute bottom-3 left-3">
                                <span class="bg-primary-950/80 backdrop-blur-sm text-amber-300 text-[11px] font-bold px-2.5 py-1 rounded-lg border border-amber-400/20">
                                    {{ $kiosk->menus->count() }} Menu Tersedia
                                </span>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary-700 transition-colors mb-1">{{ $kiosk->name }}</h3>
                            <p class="text-xs text-slate-500 font-medium mb-2">Penjual: <span class="text-slate-800 font-semibold">{{ $kiosk->user->name }}</span></p>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-4">{{ $kiosk->description ?? 'Lihat menu makanan dan minuman lezat yang tersedia di kios ini.' }}</p>

                            <div class="mt-auto pt-3 flex items-center justify-between border-t border-slate-100 text-primary-700 font-bold text-xs">
                                <span>Buka Daftar Menu</span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
