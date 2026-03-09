@extends('layouts.app')

@section('title', $kantin->name)

@section('content')
    {{-- ═══ Header ═══ --}}
    <div class="bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="flex items-center justify-center w-10 h-10 rounded-xl bg-gray-100 hover:bg-primary-100 text-gray-600 hover:text-primary-500 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">{{ $kantin->name }}</h1>
                    <p class="text-sm text-gray-500">{{ $kantin->kiosks->count() }} kios tersedia</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ Kantin Description ═══ --}}
    @if($kantin->description)
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
            <div class="bg-gradient-to-r from-primary-50 to-amber-50 rounded-2xl p-6 border border-primary-100">
                <p class="text-gray-600 text-sm leading-relaxed">{{ $kantin->description }}</p>
            </div>
        </div>
    @endif

    {{-- ═══ Kios Grid ═══ --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($kantin->kiosks->isEmpty())
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-400 mb-1">Belum ada kios</h3>
                <p class="text-sm text-gray-400">Kantin ini belum memiliki kios.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($kantin->kiosks as $kiosk)
                    <a href="{{ route('kiosk.show', $kiosk) }}" class="group card-hover">
                        {{-- Image --}}
                        <div class="relative h-44 bg-gradient-to-br from-primary-100 to-amber-100 overflow-hidden">
                            @if($kiosk->image)
                                <img src="{{ asset('storage/' . $kiosk->image) }}" alt="{{ $kiosk->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-primary-300 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h18v18H3zM12 8v4m0 4h.01"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-primary-500 transition-colors mb-1">{{ $kiosk->name }}</h3>
                            <p class="text-xs text-primary-500 font-medium mb-2">{{ $kiosk->user->name }}</p>
                            <p class="text-sm text-gray-500 line-clamp-2">{{ $kiosk->description ?? 'Lihat menu yang tersedia.' }}</p>

                            <div class="mt-3 flex items-center gap-2 text-primary-500 font-semibold text-sm">
                                <span>Lihat Menu</span>
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
