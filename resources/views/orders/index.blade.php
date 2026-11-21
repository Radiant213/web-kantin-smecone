@extends('layouts.app')

@section('title', 'Pesanan & Nota Digital')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Pesanan &amp; Nota Digital</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Tunjukkan nota digital di bawah ini ke meja baki kios saat jam istirahat.</p>
            </div>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 shadow-sm transition-all self-start sm:self-auto">
                <svg class="w-4 h-4 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Pesan Menu Lain
            </a>
        </div>

        @if($orders->isEmpty())
            <div class="bg-white rounded-3xl border border-slate-200/80 p-10 sm:p-14 text-center max-w-lg mx-auto shadow-sm">
                <div class="w-16 h-16 rounded-2xl bg-primary-50 text-primary-700 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-base font-extrabold text-slate-900 mb-1">Belum Ada Pesanan Aktif</h3>
                <p class="text-xs text-slate-500 mb-6 max-w-xs mx-auto leading-relaxed">
                    Anda belum memesan makanan atau minuman hari ini. Pre-order sekarang sebelum bel berbunyi!
                </p>
                <a href="{{ route('home') }}" class="btn-primary text-xs py-2.5 px-5">Jelajahi Kantin Sekolah</a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    @php
                        $isPaid = ($order->payment_status === 'paid');
                        $statusText = match($order->status) {
                            'pending' => 'Menunggu Konfirmasi Kios',
                            'processing' => 'Sedang Dimasak / Disiapkan',
                            'completed' => 'Siap Diambil di Kios',
                            'cancelled' => 'Pesanan Dibatalkan',
                            default => ucfirst($order->status),
                        };
                        $statusBadgeClass = match($order->status) {
                            'pending' => 'bg-amber-50 text-amber-800 border-amber-200',
                            'processing' => 'bg-sky-50 text-sky-800 border-sky-200 animate-pulse',
                            'completed' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                            'cancelled' => 'bg-rose-50 text-rose-800 border-rose-200',
                            default => 'bg-slate-50 text-slate-700 border-slate-200',
                        };
                        $sessionLabel = ($order->pickup_session === 'istirahat_2') ? 'Istirahat 2 (12:00 - 12:45 WIB)' : 'Istirahat 1 (09:45 - 10:15 WIB)';
                        $orderCode = $order->order_code ?? ('#SMC-' . str_pad($order->id, 4, '0', STR_PAD_LEFT));
                    @endphp

                    {{-- ═══ Digital Receipt Card ═══ --}}
                    <div class="bg-white rounded-3xl border-2 {{ $order->status === 'completed' ? 'border-emerald-300 ring-2 ring-emerald-100' : 'border-slate-200/90' }} p-6 sm:p-7 space-y-5 shadow-sm hover:shadow-md transition-all">
                        
                        {{-- Receipt Top Bar --}}
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                            <div>
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span class="text-[10px] font-extrabold tracking-widest text-primary-800 uppercase bg-primary-50 px-2.5 py-0.5 rounded-md border border-primary-200">
                                        NOTA PENGAMBILAN
                                    </span>
                                    @if($isPaid)
                                        <span class="inline-flex items-center gap-1 text-[10px] text-emerald-800 font-extrabold bg-emerald-50 px-2.5 py-0.5 rounded-md border border-emerald-200">
                                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            LUNAS (QRIS)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[10px] text-amber-800 font-extrabold bg-amber-50 px-2.5 py-0.5 rounded-md border border-amber-200">
                                            BELUM DIBAYAR
                                        </span>
                                    @endif
                                </div>

                                <h3 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                                    {{ $orderCode }}
                                </h3>
                                <p class="text-xs text-slate-500 mt-1">
                                    Stand: <strong class="text-slate-800">{{ $order->kiosk->name ?? 'Kios Kantin' }}</strong> &bull; 
                                    Zona: <strong>{{ $order->kiosk->kantin->name ?? 'Kantin Sekolah' }}</strong>
                                </p>
                            </div>

                            <div class="sm:text-right flex flex-col sm:items-end gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $statusBadgeClass }}">
                                    {{ $statusText }}
                                </span>

                                @if(!$isPaid && $order->snap_token)
                                    <button type="button" onclick="payWithSnap('{{ $order->snap_token }}')"
                                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white rounded-xl text-xs font-extrabold shadow-md shadow-amber-500/20 active:scale-95 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                        </svg>
                                        <span>Bayar QRIS Sekarang</span>
                                    </button>
                                @endif
                            </div>
                        </div>

                        {{-- Details Info Grid --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <div>
                                <span class="text-slate-400 block text-[11px] font-bold uppercase tracking-wider">Pemesan</span>
                                <p class="font-extrabold text-slate-900 text-sm mt-0.5">{{ $order->user->name }}</p>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[11px] font-bold uppercase tracking-wider">Jadwal Pengambilan</span>
                                <p class="font-extrabold text-primary-800 text-sm mt-0.5">{{ $sessionLabel }}</p>
                            </div>
                        </div>

                        {{-- Order Items Table --}}
                        <div class="space-y-2">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Rincian Menu Dipesan:</h4>
                            <div class="divide-y divide-slate-100 border border-slate-100 rounded-2xl overflow-hidden bg-white shadow-xs">
                                @foreach($order->items as $item)
                                    <div class="flex items-center justify-between p-3.5 text-xs">
                                        <div class="flex items-center gap-2.5">
                                            <span class="font-black text-primary-800 bg-primary-50 px-2 py-0.5 rounded-lg border border-primary-200">
                                                {{ $item->quantity }}x
                                            </span>
                                            <span class="font-bold text-slate-800">{{ $item->menu->name ?? 'Menu' }}</span>
                                        </div>
                                        <span class="font-extrabold text-slate-900">
                                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if($order->notes)
                            <div class="text-xs bg-amber-50/80 border border-amber-200/80 p-3.5 rounded-2xl text-amber-900">
                                <span class="font-bold block mb-0.5">Catatan Pembeli:</span>
                                "{{ $order->notes }}"
                            </div>
                        @endif

                        {{-- Total & Instructions --}}
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-3 border-t border-slate-100">
                            <p class="text-xs text-slate-500 text-center sm:text-left flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Cukup tunjukkan nomor nota ini ke penjual stand saat jam istirahat.</span>
                            </p>
                            <div class="text-right">
                                <span class="text-xs text-slate-400">Total Tagihan:</span>
                                <span class="text-xl font-black text-primary-800 ml-1">
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
    @php
        $isProd = filter_var(config('services.midtrans.is_production', false), FILTER_VALIDATE_BOOLEAN);
        $midtransSnapUrl = $isProd
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
        $clientKey = config('services.midtrans.client_key');
    @endphp
    <script src="{{ $midtransSnapUrl }}" data-client-key="{{ $clientKey }}"></script>

    <script>
        function payWithSnap(snapToken) {
            if (!snapToken) {
                alert('Token pembayaran tidak valid.');
                return;
            }

            if (typeof snap !== 'undefined') {
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        window.location.reload();
                    },
                    onPending: function(result) {
                        window.location.reload();
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal atau terjadi kesalahan.');
                        window.location.reload();
                    },
                    onClose: function() {
                        // User closed the popup
                    }
                });
            } else {
                console.warn('Midtrans Snap SDK is loading, retrying...');
                setTimeout(() => payWithSnap(snapToken), 800);
            }
        }

        // Auto trigger Snap popup if pay_order_id query param exists
        document.addEventListener("DOMContentLoaded", () => {
            const urlParams = new URLSearchParams(window.location.search);
            const payOrderId = urlParams.get('pay_order_id');
            @if(isset($orders) && $orders->isNotEmpty())
                @foreach($orders as $o)
                    if (payOrderId == '{{ $o->id }}' && '{{ $o->snap_token }}') {
                        setTimeout(() => payWithSnap('{{ $o->snap_token }}'), 400);
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
