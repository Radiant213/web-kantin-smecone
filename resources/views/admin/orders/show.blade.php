@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="max-w-4xl">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.orders.index') }}"
                class="flex items-center justify-center w-10 h-10 rounded-xl bg-gray-100 hover:bg-primary-100 text-gray-600 hover:text-primary-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Pesanan #{{ $order->id }}</h1>
                <p class="text-sm text-gray-500 mt-0.5">{{ $order->created_at->format('l, d F Y - H:i') }}</p>
            </div>
            <div class="ml-auto">
                @php
                    $statusColors = [
                        'pending' => 'badge-warning',
                        'processing' => 'badge-info',
                        'completed' => 'badge-success',
                        'cancelled' => 'badge-danger',
                    ];
                    $statusLabels = [
                        'pending' => 'Menunggu',
                        'processing' => 'Diproses',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ];
                @endphp
                <span
                    class="{{ $statusColors[$order->status] ?? 'badge' }} text-sm px-4 py-1.5">{{ $statusLabels[$order->status] ?? $order->status }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            {{-- Customer Info --}}
            <div class="card p-5">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Informasi Pembeli</h3>
                        <p class="text-xs text-gray-500">Customer Details</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <p class="text-sm"><span class="text-gray-500 w-20 inline-block">Nama:</span> <span
                            class="font-medium text-gray-800">{{ $order->user->name }}</span></p>
                    <p class="text-sm"><span class="text-gray-500 w-20 inline-block">Email:</span> <span
                            class="font-medium text-gray-800">{{ $order->user->email }}</span></p>
                </div>
            </div>

            {{-- Kiosk Info --}}
            <div class="card p-5">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Informasi Kios</h3>
                        <p class="text-xs text-gray-500">Seller Details</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <p class="text-sm"><span class="text-gray-500 w-20 inline-block">Kios:</span> <span
                            class="font-medium text-gray-800">{{ $order->kiosk->name }}</span></p>
                    <p class="text-sm"><span class="text-gray-500 w-20 inline-block">Penjual:</span> <span
                            class="font-medium text-gray-800">{{ $order->kiosk->user->name }}</span></p>
                </div>
            </div>

            {{-- Update Status --}}
            <div class="card p-5 bg-gradient-to-br from-gray-50 to-white">
                <h3 class="font-semibold text-gray-800 mb-4">Update Status</h3>
                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="space-y-3">
                    @csrf @method('PATCH')
                    <select name="status" class="input-field py-2 text-sm" required>
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu (Pending)
                        </option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses
                            (Processing)</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai (Completed)
                        </option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)
                        </option>
                    </select>
                    <button type="submit" class="btn-primary w-full py-2 text-sm">Update</button>
                </form>
            </div>
        </div>

        {{-- Order Items --}}
        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="font-semibold text-gray-800">Daftar Menu Pesanan</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4 py-2 border-b border-gray-50 last:border-0 last:pb-0">
                            <div class="w-16 h-16 rounded-xl bg-gray-100 flex-shrink-0 overflow-hidden">
                                @if($item->menu->image)
                                    <img src="{{ asset('storage/' . $item->menu->image) }}" alt="{{ $item->menu->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-800">{{ $item->menu->name }}</h4>
                                <p class="text-sm text-gray-500">Rp {{ number_format($item->price, 0, ',', '.') }} ×
                                    {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right whitespace-nowrap">
                                <p class="font-bold text-gray-800">Rp {{ number_format($item->subtotal(), 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <div class="flex justify-between items-center text-lg">
                        <span class="font-bold text-gray-800">Total Pembayaran</span>
                        <span class="font-black text-2xl text-primary-500">{{ $order->formattedTotal() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection