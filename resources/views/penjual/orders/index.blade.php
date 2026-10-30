<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-amber-400 text-primary-950">Dapur Stand</span>
                    <span class="text-xs text-slate-500">Kantin Resmi SMECONE</span>
                </div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                    Pesanan Masuk: {{ $kiosk->name }}
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('profile.edit') }}"
                    class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-primary-700 bg-white border border-slate-200 px-3.5 py-2 rounded-xl shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Pengaturan Stand
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Manajemen Antrean Dapur</h3>
                    <p class="text-xs text-slate-500">Kelola status pesanan pembeli agar siap tepat waktu di jam istirahat.</p>
                </div>
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-600">
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Pesanan Real-time Aktif
                </div>
            </div>

            @if($orders->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach($orders as $order)
                        @php
                            $currentStatus = $order->status;
                            $orderCode = $order->order_code ?? ('#SMC-' . str_pad($order->id, 5, '0', STR_PAD_LEFT));
                            $isPaid = ($order->payment_status === 'paid');
                        @endphp
                        <div class="bg-white border {{ $currentStatus === 'processing' ? 'border-amber-300 ring-2 ring-amber-200/50' : 'border-slate-200' }} rounded-3xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                {{-- Card Header --}}
                                <div class="flex items-start justify-between gap-3 pb-4 border-b border-slate-100">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-mono font-extrabold text-sm text-primary-700 bg-primary-50 px-2 py-0.5 rounded-lg border border-primary-200">
                                                {{ $orderCode }}
                                            </span>
                                            @if($isPaid)
                                                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    LUNAS CASHLESS
                                                </span>
                                            @else
                                                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                                    Menunggu Bayar
                                                </span>
                                            @endif
                                        </div>
                                        <h4 class="text-base font-extrabold text-slate-900 mt-2">
                                            {{ $order->user->name }}
                                        </h4>
                                        <p class="text-xs text-slate-400 mt-0.5">
                                            Dipesan: {{ $order->created_at->format('d M Y, H:i') }} WIB
                                        </p>
                                    </div>

                                    <div class="text-right">
                                        <span class="text-[10px] font-bold uppercase tracking-wider block text-slate-400">Jadwal Ambil</span>
                                        <span class="inline-block mt-0.5 px-2.5 py-1 rounded-xl text-xs font-bold {{ ($order->pickup_session ?? 'istirahat_1') === 'istirahat_2' ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }}">
                                            {{ ($order->pickup_session ?? 'istirahat_1') === 'istirahat_2' ? 'Istirahat 2 (11:45)' : 'Istirahat 1 (09:30)' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Notes / Catatan Pembeli --}}
                                @if($order->notes)
                                    <div class="my-3 p-3 bg-amber-50/70 rounded-xl border border-amber-200/60 text-xs text-amber-900">
                                        <span class="font-bold block mb-0.5">Catatan Pembeli:</span>
                                        "{{ $order->notes }}"
                                    </div>
                                @endif

                                {{-- Order Items List --}}
                                <div class="py-4 space-y-2.5">
                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Rincian Hidangan:</p>
                                    @foreach($order->items as $item)
                                        <div class="flex justify-between items-center text-sm bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                            <div class="flex items-center gap-2.5">
                                                <span class="w-6 h-6 rounded-lg bg-primary-100 text-primary-800 font-extrabold text-xs flex items-center justify-center">
                                                    {{ $item->quantity }}x
                                                </span>
                                                <span class="font-bold text-slate-800">{{ $item->menu->name }}</span>
                                            </div>
                                            <span class="text-xs font-semibold text-slate-500">
                                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Footer & Action Buttons --}}
                            <div class="pt-4 border-t border-slate-100 mt-2">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-xs text-slate-500 font-medium">Total Pembayaran</span>
                                    <span class="text-base font-extrabold text-slate-900">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="flex flex-wrap items-center gap-2">
                                    @if($currentStatus === 'pending')
                                        <form method="POST" action="{{ route('penjual.orders.updateStatus', $order) }}" class="flex-1">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="processing">
                                            <button type="submit"
                                                class="w-full bg-primary-700 hover:bg-primary-800 text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-sm transition-all active:scale-95 flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Terima &amp; Siapkan Masakan
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('penjual.orders.updateStatus', $order) }}"
                                            onsubmit="return confirm('Batalkan pesanan ini?')">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit"
                                                class="px-3.5 py-2.5 rounded-xl text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition-colors">
                                                Tolak
                                            </button>
                                        </form>
                                    @elseif($currentStatus === 'processing')
                                        <form method="POST" action="{{ route('penjual.orders.updateStatus', $order) }}" class="flex-1">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit"
                                                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-sm transition-all active:scale-95 flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Tandai Siap Diambil / Selesai
                                            </button>
                                        </form>
                                    @elseif($currentStatus === 'completed')
                                        <div class="w-full bg-emerald-50 border border-emerald-200 text-emerald-800 px-3.5 py-2 rounded-xl text-xs font-bold flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Pesanan Telah Diambil Siswa
                                        </div>
                                    @elseif($currentStatus === 'cancelled')
                                        <div class="w-full bg-rose-50 border border-rose-200 text-rose-700 px-3.5 py-2 rounded-xl text-xs font-bold flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Pesanan Dibatalkan
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-20 px-4 bg-white rounded-3xl border border-slate-200 shadow-sm">
                    <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Pesanan Masuk</h3>
                    <p class="text-slate-500 text-xs sm:text-sm max-w-sm mx-auto">
                        Stand Anda belum memiliki pesanan saat ini. Pesanan baru dari siswa akan langsung muncul secara real-time di sini.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
