@extends('layouts.app')

@section('title', 'Pesanan & Nota Digital')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pesanan & Nota Digital</h1>
                <p class="text-xs text-slate-500 font-medium">Tunjukkan nota digital di bawah ini ke meja kios saat jam istirahat.</p>
            </div>
            <a href="{{ route('home') }}" class="btn-outline text-xs py-2 px-4 self-start sm:self-auto">
                + Pesan Menu Lain
            </a>
        </div>

        @if($orders->isEmpty())
            <div class="card p-12 text-center max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4 text-2xl">
                    📋
                </div>
                <h3 class="text-base font-bold text-slate-800 mb-1">Belum Ada Pesanan Aktif</h3>
                <p class="text-xs text-slate-500 mb-6 max-w-xs mx-auto">
                    Anda belum memesan makanan atau minuman hari ini. Yuk pre-order sekarang!
                </p>
                <a href="{{ route('home') }}" class="btn-primary text-xs">Jelajahi Kantin Sekolah</a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    @php
                        $isPaid = ($order->payment_status === 'paid');
                        $statusText = match($order->status) {
                            'pending' => 'Menunggu Konfirmasi Kios',
                            'processing' => 'Sedang Dimasak di Kios',
                            'completed' => 'Siap Diambil / Selesai',
                            'cancelled' => 'Dibatalkan',
                            default => $order->status,
                        };
                        $statusBadgeClass = match($order->status) {
                            'pending' => 'badge-warning',
                            'processing' => 'badge-info animate-pulse',
                            'completed' => 'badge-success',
                            'cancelled' => 'badge-danger',
                            default => 'badge',
                        };
                        $sessionLabel = ($order->pickup_session === 'istirahat_2') ? 'Istirahat 2 (12:00 WIB)' : 'Istirahat 1 (09:45 WIB)';
                    @endphp

                    {{-- ═══ Simple Digital Receipt Card ═══ --}}
                    <div class="card border-2 {{ $order->status === 'completed' ? 'border-emerald-300' : 'border-slate-200/80' }} p-6 space-y-5">
                        
                        {{-- Receipt Top Bar --}}
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                            <div>
                                <span class="text-[10px] font-black tracking-widest text-primary-800 uppercase bg-primary-50 px-2.5 py-1 rounded-md">
                                    NOTA PENGAMBILAN
                                </span>
                                <h3 class="text-2xl font-black text-slate-900 mt-1 tracking-tight">
                                    {{ $order->order_code ?? ('#SMC-' . str_pad($order->id, 4, '0', STR_PAD_LEFT)) }}
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    Kios: <strong class="text-slate-800">{{ $order->kiosk->name ?? 'Kios Kantin' }}</strong> • 
                                    Zona: <strong>{{ $order->kiosk->kantin->name ?? 'Kantin' }}</strong>
                                </p>
                            </div>

                            <div class="sm:text-right">
                                <span class="{{ $statusBadgeClass }} text-xs font-bold px-3 py-1">
                                    {{ $statusText }}
                                </span>
                                <div class="mt-2 text-xs">
                                    @if($isPaid)
                                        <span class="inline-flex items-center gap-1 text-emerald-700 font-bold bg-emerald-50 px-2.5 py-0.5 rounded border border-emerald-200">
                                            ✓ LUNAS (QRIS)
                                        </span>
                                    @else
                                        @if($order->snap_token)
                                            <button onclick="payWithSnap('{{ $order->snap_token }}')" 
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition-colors">
                                                <span>Bayar QRIS Sekarang</span>
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                            </button>
                                        @else
                                            <span class="text-amber-600 font-bold">Menunggu Pembayaran</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Receipt Details (Clean & Human Readable) --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <div>
                                <span class="text-slate-400">Atas Nama Pemesan:</span>
                                <p class="font-bold text-slate-900 text-sm mt-0.5">{{ $order->user->name }}</p>
                            </div>
                            <div>
                                <span class="text-slate-400">Sesi Pengambilan:</span>
                                <p class="font-bold text-slate-900 text-sm mt-0.5">⏰ {{ $sessionLabel }}</p>
                            </div>
                        </div>

                        {{-- Order Items Table --}}
                        <div class="space-y-2">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Daftar Menu:</h4>
                            <div class="divide-y divide-slate-100 border border-slate-100 rounded-xl overflow-hidden bg-white">
                                @foreach($order->items as $item)
                                    <div class="flex items-center justify-between p-3 text-xs">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-primary-800 bg-primary-50 px-2 py-0.5 rounded">
                                                {{ $item->quantity }}x
                                            </span>
                                            <span class="font-semibold text-slate-800">{{ $item->menu->name }}</span>
                                        </div>
                                        <span class="font-bold text-slate-900">
                                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if($order->notes)
                            <div class="text-xs bg-amber-50/70 border border-amber-200/60 p-3 rounded-xl text-amber-900">
                                <strong>Catatan untuk Kios:</strong> {{ $order->notes }}
                            </div>
                        @endif

                        {{-- Total & Instructions --}}
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-3 border-t border-slate-100">
                            <p class="text-xs text-slate-500 text-center sm:text-left">
                                💡 Cukup tunjukkan layar ini ke penjual saat jam istirahat.
                            </p>
                            <div class="text-right">
                                <span class="text-xs text-slate-400">Total Harga:</span>
                                <span class="text-lg font-black text-primary-800 ml-1">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
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
@endsection

@push('scripts')
    {{-- Midtrans Snap JS --}}
    @php
        $midtransSnapUrl = config('services.midtrans.is_production', false)
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
        $clientKey = config('services.midtrans.client_key');
    @endphp
    <script src="{{ $midtransSnapUrl }}" data-client-key="{{ $clientKey }}"></script>

    <script>
        function payWithSnap(snapToken) {
            if (typeof snap !== 'undefined' && snapToken) {
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        window.location.reload();
                    },
                    onPending: function(result) {
                        window.location.reload();
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal atau dibatalkan.');
                        window.location.reload();
                    },
                    onClose: function() {
                        // User closed without finishing
                    }
                });
            }
        }

        // Auto trigger Snap popup if pay_order_id query param exists
        document.addEventListener("DOMContentLoaded", () => {
            const urlParams = new URLSearchParams(window.location.search);
            const payOrderId = urlParams.get('pay_order_id');
            @if(isset($orders) && $orders->isNotEmpty())
                @foreach($orders as $o)
                    if (payOrderId == '{{ $o->id }}' && '{{ $o->snap_token }}') {
                        payWithSnap('{{ $o->snap_token }}');
                    }
                @endforeach
            @endif

            // WebSocket Live Auto-refresh on Status Update
            if (typeof Echo !== 'undefined' && {{ auth()->check() ? 'true' : 'false' }}) {
                Echo.private('user.{{ auth()->id() }}')
                    .listen('OrderStatusUpdated', (e) => {
                        window.location.reload();
                    });
            }
        });
    </script>
@endpush
