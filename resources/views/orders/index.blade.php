@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-8">Pesanan Saya</h1>

        @if($orders->isEmpty())
            <div class="text-center py-16">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-400 mb-2">Belum ada pesanan</h3>
                <p class="text-sm text-gray-400 mb-6">Pesan makanan favoritmu sekarang!</p>
                <a href="{{ route('home') }}" class="btn-primary">Jelajahi Kantin</a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="card p-5" x-data="{ open: false }">
                        <div class="flex items-center justify-between cursor-pointer" @click="open = !open">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-1">
                                    <h3 class="font-semibold text-gray-800">Order #{{ $order->id }}</h3>
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
                                    <span class="{{ $statusColors[$order->status] ?? 'badge' }}">{{ $statusLabels[$order->status] ?? $order->status }}</span>
                                </div>
                                <p class="text-xs text-gray-500">{{ $order->kiosk->name }} · {{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-primary-500">{{ $order->formattedTotal() }}</p>
                                <svg class="w-4 h-4 text-gray-400 mt-1 ml-auto transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Order Items --}}
                        <div x-show="open" x-transition class="mt-4 pt-4 border-t border-gray-100">
                            <div class="space-y-2">
                                @foreach($order->items as $item)
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600">{{ $item->menu->name }} × {{ $item->quantity }}</span>
                                        <span class="text-gray-700 font-medium">Rp {{ number_format($item->subtotal(), 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                if (typeof Echo !== 'undefined' && {{ auth()->check() ? 'true' : 'false' }}) {
                    Echo.private('user.{{ auth()->id() }}')
                        .listen('OrderStatusUpdated', (e) => {
                            // Show a small notification then reload
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Status Pesanan Berubah',
                                    text: e.message,
                                    timer: 2000,
                                    showConfirmButton: false,
                                    toast: true,
                                    position: 'top-end'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                window.location.reload();
                            }
                        });
                }
            });
        </script>
    @endpush
@endsection
