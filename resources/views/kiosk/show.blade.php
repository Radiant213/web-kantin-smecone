@extends('layouts.app')

@section('title', $kiosk->name)

@section('content')
    {{-- ═══ Kiosk Cover + Glassmorphism Info ═══ --}}
    <div class="relative h-64 md:h-80 bg-gradient-to-br from-primary-400 via-primary-500 to-amber-400 overflow-hidden">
        @if($kiosk->image)
            <img src="{{ asset('storage/' . $kiosk->image) }}" alt="{{ $kiosk->name }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
        @else
            <div class="absolute inset-0">
                <div class="absolute top-6 right-12 w-52 h-52 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-6 left-12 w-72 h-72 bg-yellow-300/10 rounded-full blur-2xl"></div>
            </div>
        @endif

        {{-- Back button --}}
        <div class="absolute top-4 left-4 z-10">
            <a href="{{ route('kantin.show', $kiosk->kantin) }}"
                class="flex items-center justify-center w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md border border-white/30 text-white hover:bg-white/30 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        </div>

        {{-- Glassmorphism Info Card --}}
        <div class="absolute bottom-6 left-4 right-4 md:left-8 md:right-8 glassmorphism p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white drop-shadow-md">{{ $kiosk->name }}</h1>
                    <p class="text-white/80 text-sm mt-1">
                        <span class="font-medium">{{ $kiosk->user->name }}</span> · {{ $kiosk->kantin->name }}
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="bg-white/30 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $kiosk->menus->count() }} Menu
                    </span>
                </div>
            </div>
            @if($kiosk->description)
                <p class="text-white/70 text-sm mt-3 line-clamp-2">{{ $kiosk->description }}</p>
            @endif
        </div>
    </div>

    {{-- ═══ Menu Grid ═══ --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Menu</h2>
            <span class="text-sm text-gray-400">{{ $kiosk->menus->count() }} item</span>
        </div>

        @if($kiosk->menus->isEmpty())
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-400">Belum ada menu</h3>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($kiosk->menus as $menu)
                    <div class="card overflow-hidden">
                        {{-- Menu Image --}}
                        <div class="relative h-40 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                            @if($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}"
                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Menu Info --}}
                        <div class="p-5">
                            <h3 class="font-bold text-gray-800 mb-1">{{ $menu->name }}</h3>
                            @if($menu->description)
                                <p class="text-xs text-gray-500 mb-3 line-clamp-2">{{ $menu->description }}</p>
                            @endif

                            <div class="flex items-center justify-between mt-auto">
                                <span class="text-lg font-bold text-primary-500">{{ $menu->formattedPrice() }}</span>

                                @auth
                                    <form method="POST" action="{{ route('cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                            class="inline-flex items-center gap-1.5 bg-primary-500 hover:bg-primary-600 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Keranjang
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="inline-flex items-center gap-1.5 bg-primary-500 hover:bg-primary-600 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
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