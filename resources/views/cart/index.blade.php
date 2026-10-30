@extends('layouts.app')

@section('title', 'Baki Pesanan')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('home') }}"
                class="flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-primary-800 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Baki Keranjang Anda</h1>
                <p class="text-xs text-slate-500 font-medium">{{ count($items) }} jenis menu siap dipesan</p>
            </div>
        </div>

        @if(empty($items))
            <div class="card p-12 text-center max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4 text-2xl">
                    🛒
                </div>
                <h3 class="text-base font-bold text-slate-800 mb-1">Baki Pesanan Masih Kosong</h3>
                <p class="text-xs text-slate-500 mb-6 max-w-xs mx-auto">
                    Yuk pilih menu makanan atau minuman favoritmu dari kios kantin SMECONE!
                </p>
                <a href="{{ route('home') }}" class="btn-primary text-xs">Jelajahi Kantin Sekolah</a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                {{-- Left: Items List --}}
                <div class="lg:col-span-7 space-y-4">
                    @foreach($items as $item)
                        <div class="card p-4 flex items-center gap-4">
                            {{-- Image --}}
                            <div class="w-16 h-16 rounded-xl bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200/60">
                                @if($item['menu']->image)
                                    <img src="{{ asset('storage/' . $item['menu']->image) }}" alt="{{ $item['menu']->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        🍲
                                    </div>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <span class="text-[10px] font-bold text-primary-800 uppercase tracking-wider">
                                    {{ $item['menu']->kiosk->name ?? 'Kios Kantin' }}
                                </span>
                                <h3 class="font-bold text-sm text-slate-900 truncate">{{ $item['menu']->name }}</h3>
                                <p class="text-xs font-black text-slate-800 mt-1">
                                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                </p>
                            </div>

                            {{-- Qty & Remove --}}
                            <div class="flex items-center gap-3">
                                <span class="bg-slate-100 px-2.5 py-1 rounded-lg text-xs font-bold text-slate-700">
                                    {{ $item['quantity'] }}x
                                </span>
                                <form method="POST" action="{{ route('cart.remove', $item['menu']->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors">
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

                {{-- Right: Checkout Form --}}
                <div class="lg:col-span-5">
                    <form method="POST" action="{{ route('cart.checkout') }}" class="card p-6 space-y-5">
                        @csrf
                        <h2 class="text-base font-extrabold text-slate-900 pb-3 border-b border-slate-100">
                            Konfirmasi Pengambilan
                        </h2>

                        {{-- Slot Jam Istirahat --}}
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-700">
                                Pilih Sesi Pengambilan di Kios:
                            </label>
                            <div class="grid grid-cols-1 gap-2">
                                <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors has-[:checked]:border-primary-800 has-[:checked]:bg-primary-50/50">
                                    <input type="radio" name="pickup_session" value="istirahat_1" checked class="text-primary-800 focus:ring-primary-700">
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">⏰ Istirahat 1 (09:45 - 10:15 WIB)</p>
                                        <p class="text-[11px] text-slate-500">Paling cocok untuk sarapan & camilan</p>
                                    </div>
                                </label>

                                <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors has-[:checked]:border-primary-800 has-[:checked]:bg-primary-50/50">
                                    <input type="radio" name="pickup_session" value="istirahat_2" class="text-primary-800 focus:ring-primary-700">
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">⏰ Istirahat 2 (12:00 - 12:45 WIB)</p>
                                        <p class="text-[11px] text-slate-500">Makan siang utama & istirahat sholat</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Catatan Pesanan --}}
                        <div class="space-y-1.5">
                            <label for="notes" class="block text-xs font-bold text-slate-700">
                                Catatan Khusus untuk Kios (Opsional):
                            </label>
                            <textarea name="notes" id="notes" rows="2" 
                                      placeholder="Contoh: sambal dipisah, es batu sedikit, dll."
                                      class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:border-primary-800 focus:ring-1 focus:ring-primary-800 resize-none"></textarea>
                        </div>

                        {{-- Total & Cashless Guarantee --}}
                        <div class="pt-4 border-t border-slate-100 space-y-3">
                            <div class="flex items-center justify-between text-xs text-slate-500">
                                <span>Metode Bayar</span>
                                <span class="font-bold text-slate-800">QRIS Midtrans (Instant)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700">Total Pembayaran</span>
                                <span class="text-xl font-black text-primary-800">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>

                            <button type="submit" class="w-full btn-primary py-3.5 text-sm font-bold flex items-center justify-center gap-2">
                                <span>Lanjut Pembayaran QRIS</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>

                            <p class="text-[11px] text-center text-slate-400">
                                🔒 Pembayaran diproses aman oleh Midtrans Payment Gateway
                            </p>
                        </div>
                    </form>
                </div>

            </div>
        @endif
    </div>
@endsection
