@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    {{-- ═══ Hero Section ═══ --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-primary-500 via-primary-400 to-amber-400">
        <div class="absolute inset-0">
            <div class="absolute top-10 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-yellow-300/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-orange-300/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
            <div class="text-center">
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-6">
                    <span class="w-3 h-3 rounded-full border-2 border-white border-t-white/20 border-r-white/20 animate-spin-blink"></span>
                    <span class="text-white/90 text-sm font-medium">SMKN 1 Purwokerto</span>
                </div>

                <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight">
                    Jajan Gampang,<br>
                    <span class="text-yellow-200">Perut Kenyang</span>
                </h1>

                <p class="text-lg md:text-xl text-white/80 max-w-2xl mx-auto mb-10">
                    Pesan makanan favoritmu dari kantin sekolah dengan mudah.<br class="hidden md:block">
                    Tinggal pilih, pesan, dan ambil!
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="#kantin" class="group inline-flex items-center gap-2 bg-white text-primary-600 font-bold px-8 py-4 rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-0.5 transition-all duration-300">
                        <span>Lihat Kantin</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white font-bold px-8 py-4 rounded-2xl border-2 border-white/30 hover:bg-white/30 transition-all duration-300">
                            Daftar Sekarang
                        </a>
                    @endguest
                </div>
            </div>
        </div>

        {{-- Wave separator --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#F9FAFB"/>
            </svg>
        </div>
    </section>

    {{-- ═══ Pilih Kantin Section ═══ --}}
    <section id="kantin" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="text-center mb-12">
            <span class="inline-block bg-primary-100 text-primary-600 text-sm font-semibold px-4 py-1 rounded-full mb-4">Kantin Tersedia</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Pilih Kantin</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Jelajahi berbagai kantin yang tersedia di SMKN 1 Purwokerto dan temukan makanan favoritmu.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
            @foreach($kantins as $kantin)
                <a href="{{ route('kantin.show', $kantin) }}" class="group card-hover">
                    {{-- Image --}}
                    <div class="relative h-48 md:h-56 bg-gradient-to-br from-primary-100 to-primary-200 overflow-hidden">
                        @if($kantin->image)
                            <img src="{{ asset('storage/' . $kantin->image) }}" alt="{{ $kantin->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-primary-300 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm rounded-full px-3 py-1 text-xs font-semibold text-primary-600">
                            {{ $kantin->kiosks_count }} Kios
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-primary-500 transition-colors mb-2">{{ $kantin->name }}</h3>
                        <p class="text-sm text-gray-500 line-clamp-2">{{ $kantin->description ?? 'Jelajahi aneka kuliner di kantin ini.' }}</p>

                        <div class="mt-4 flex items-center gap-2 text-primary-500 font-semibold text-sm">
                            <span>Lihat Kios</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ═══ CTA Section ═══ --}}
    <section class="bg-gradient-to-r from-primary-500 to-amber-400 py-16">
        <div class="max-w-4xl mx-auto px-4 text-center">
            @guest
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Belum Punya Akun?</h2>
                <p class="text-white/80 text-lg mb-8">Daftar sekarang dan mulai pesan makanan favoritmu dengan mudah!</p>
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white text-primary-600 font-bold px-8 py-4 rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-0.5 transition-all duration-300">
                    Daftar Gratis
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            @else
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Lapar? Atau Haus?</h2>
                <p class="text-white/80 text-lg mb-8">Ayo lihat kantin di sini dan mulai pesananmu sekarang!</p>
                <a href="#kantin" class="inline-flex items-center gap-2 bg-white text-primary-600 font-bold px-8 py-4 rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-0.5 transition-all duration-300">
                    Mulai Pesanan Sekarang
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                </a>
            @endguest
        </div>
    </section>
@endsection
