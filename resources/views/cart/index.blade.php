@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ url()->previous() }}"
                class="flex items-center justify-center w-10 h-10 rounded-xl bg-gray-100 hover:bg-primary-100 text-gray-600 hover:text-primary-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Keranjang</h1>
                <p class="text-sm text-gray-500">{{ count($items) }} item</p>
            </div>
        </div>

        @if(empty($items))
            <div class="text-center py-16">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-400 mb-2">Keranjang Kosong</h3>
                <p class="text-sm text-gray-400 mb-6">Yuk, pesan makanan favoritmu!</p>
                <a href="{{ route('home') }}" class="btn-primary">Jelajahi Kantin</a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($items as $item)
                    <div class="card p-4 flex items-center gap-4">
                        {{-- Image --}}
                        <div class="w-16 h-16 rounded-xl bg-gray-100 flex-shrink-0 overflow-hidden">
                            @if($item['menu']->image)
                                <img src="{{ asset('storage/' . $item['menu']->image) }}" alt="{{ $item['menu']->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-800 truncate">{{ $item['menu']->name }}</h3>
                            <p class="text-xs text-gray-500">{{ $item['menu']->kiosk->name }}</p>
                            <p class="text-sm font-bold text-primary-500 mt-1">Rp
                                {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                        </div>

                        {{-- Qty & Remove --}}
                        <div class="flex items-center gap-3">
                            <span
                                class="bg-gray-100 px-3 py-1 rounded-lg text-sm font-semibold text-gray-700">x{{ $item['quantity'] }}</span>
                            <form method="POST" action="{{ route('cart.remove', $item['menu']->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Total & Checkout --}}
            <div class="mt-8 card p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-600 font-medium">Total</span>
                    <span class="text-2xl font-bold text-primary-500">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <form method="POST" action="{{ route('cart.checkout') }}">
                    @csrf
                    <button type="submit" class="w-full btn-primary py-4 text-lg">
                        Checkout Sekarang
                    </button>
                </form>
            </div>
        @endif
    </div>
@endsection