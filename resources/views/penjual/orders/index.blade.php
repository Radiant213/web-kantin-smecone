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
            <div class="flex items-center gap-2.5">
                <a href="{{ route('penjual.kiosk.index') }}"
                    class="inline-flex items-center gap-2 text-xs font-bold text-slate-700 hover:text-primary-800 bg-white border border-slate-200 px-3.5 py-2 rounded-xl shadow-xs transition-colors">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Kelola Kios &amp; Menu</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ═══ Real-time Connection Status Header ═══ --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-800">Manajemen Antrean Dapur</h3>
                    <p class="text-xs text-slate-500">Pantau dan kelola pesanan siswa secara langsung agar siap di jam istirahat.</p>
                </div>
                <div class="flex items-center gap-2 text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-xl border border-emerald-200 w-fit">
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Live WebSocket Terkoneksi</span>
                </div>
            </div>

            {{-- ═══ Interactive Clickable Stats Cards (Mobile-first Horizontal Scroll) ═══ --}}
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2.5">Ringkasan Antrean (Klik untuk Filter):</p>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">

                    {{-- Card 1: Belum Bayar --}}
                    <a href="{{ route('penjual.orders.index', ['preset' => 'unpaid']) }}"
                        class="p-4 rounded-2xl border transition-all cursor-pointer flex flex-col justify-between {{ ($preset ?? 'all') === 'unpaid' ? 'bg-rose-50 border-rose-300 ring-2 ring-rose-400 shadow-xs' : 'bg-white border-slate-200 hover:border-slate-300 hover:shadow-xs' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-rose-700">Belum Bayar</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                        </div>
                        <div class="mt-3">
                            <span class="text-2xl font-black text-rose-800">{{ $stats['unpaid'] ?? 0 }}</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Menunggu QRIS</span>
                        </div>
                    </a>

                    {{-- Card 2: Menunggu Diproses (Lunas) --}}
                    <a href="{{ route('penjual.orders.index', ['preset' => 'waiting']) }}"
                        class="p-4 rounded-2xl border transition-all cursor-pointer flex flex-col justify-between {{ ($preset ?? 'all') === 'waiting' ? 'bg-amber-50 border-amber-300 ring-2 ring-amber-400 shadow-xs' : 'bg-white border-slate-200 hover:border-slate-300 hover:shadow-xs' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-amber-800">Menunggu</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                        </div>
                        <div class="mt-3">
                            <span class="text-2xl font-black text-amber-900">{{ $stats['waiting'] ?? 0 }}</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Lunas (Perlu Aksi)</span>
                        </div>
                    </a>

                    {{-- Card 3: Sedang Dimasak --}}
                    <a href="{{ route('penjual.orders.index', ['preset' => 'cooking']) }}"
                        class="p-4 rounded-2xl border transition-all cursor-pointer flex flex-col justify-between {{ ($preset ?? 'all') === 'cooking' ? 'bg-indigo-50 border-indigo-300 ring-2 ring-indigo-400 shadow-xs' : 'bg-white border-slate-200 hover:border-slate-300 hover:shadow-xs' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-indigo-800">Sedang Dimasak</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                        </div>
                        <div class="mt-3">
                            <span class="text-2xl font-black text-indigo-900">{{ $stats['cooking'] ?? 0 }}</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Proses Dapur</span>
                        </div>
                    </a>

                    {{-- Card 4: Selesai Hari Ini --}}
                    <a href="{{ route('penjual.orders.index', ['preset' => 'completed_today']) }}"
                        class="p-4 rounded-2xl border transition-all cursor-pointer flex flex-col justify-between {{ ($preset ?? 'all') === 'completed_today' ? 'bg-emerald-50 border-emerald-300 ring-2 ring-emerald-400 shadow-xs' : 'bg-white border-slate-200 hover:border-slate-300 hover:shadow-xs' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-emerald-800">Siap / Diambil</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        </div>
                        <div class="mt-3">
                            <span class="text-2xl font-black text-emerald-900">{{ $stats['completed_today'] ?? 0 }}</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Hari Ini</span>
                        </div>
                    </a>

                    {{-- Card 5: Total Hari Ini --}}
                    <a href="{{ route('penjual.orders.index', ['preset' => 'today']) }}"
                        class="p-4 rounded-2xl border transition-all cursor-pointer flex flex-col justify-between {{ ($preset ?? 'all') === 'today' ? 'bg-blue-50 border-blue-300 ring-2 ring-blue-400 shadow-xs' : 'bg-white border-slate-200 hover:border-slate-300 hover:shadow-xs' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-blue-800">Total Hari Ini</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                        </div>
                        <div class="mt-3">
                            <span class="text-2xl font-black text-blue-900">{{ $stats['total_today'] ?? 0 }}</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Semua Status</span>
                        </div>
                    </a>

                    {{-- Card 6: Semua Pesanan --}}
                    <a href="{{ route('penjual.orders.index', ['preset' => 'all']) }}"
                        class="p-4 rounded-2xl border transition-all cursor-pointer flex flex-col justify-between {{ ($preset ?? 'all') === 'all' && !request()->filled('date') && !request()->filled('status') ? 'bg-slate-100 border-slate-400 ring-2 ring-slate-400 shadow-xs' : 'bg-white border-slate-200 hover:border-slate-300 hover:shadow-xs' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-700">Semua Data</span>
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                        </div>
                        <div class="mt-3">
                            <span class="text-2xl font-black text-slate-900">{{ $stats['total_all'] ?? 0 }}</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Total Riwayat</span>
                        </div>
                    </a>

                </div>
            </div>

            {{-- ═══ Filter Bar & Search ═══ --}}
            <div class="bg-white p-4 rounded-3xl border border-slate-200 shadow-xs" x-data="{ filterOpen: false }">
                <div class="flex items-center justify-between gap-3 mb-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-700">Penyaring Data Pesanan</h4>
                    </div>
                    <div class="flex items-center gap-2">
                        @if(request()->anyFilled(['preset', 'date', 'status', 'payment_status', 'search']))
                            <a href="{{ route('penjual.orders.index') }}" class="text-xs font-bold text-rose-600 hover:underline">
                                ✕ Reset Filter
                            </a>
                        @endif
                    </div>
                </div>

                <form method="GET" action="{{ route('penjual.orders.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    {{-- Pencarian --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Cari Pesanan / Siswa</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Kode order atau nama siswa..."
                            class="w-full text-xs rounded-xl border-slate-200 focus:border-primary-800 focus:ring-primary-800/20 py-2 px-3">
                    </div>

                    {{-- Tanggal --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Tanggal Pesanan</label>
                        <input type="date" name="date" value="{{ request('date') }}"
                            class="w-full text-xs rounded-xl border-slate-200 focus:border-primary-800 focus:ring-primary-800/20 py-2 px-3">
                    </div>

                    {{-- Status Pembayaran --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Status Pembayaran</label>
                        <select name="payment_status" class="w-full text-xs rounded-xl border-slate-200 focus:border-primary-800 focus:ring-primary-800/20 py-2 px-3">
                            <option value="all">Semua Status Bayar</option>
                            <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Lunas (Cashless)</option>
                            <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Menunggu Bayar</option>
                        </select>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="flex-1 py-2 px-4 bg-primary-800 hover:bg-primary-900 text-white text-xs font-bold rounded-xl shadow-xs transition-colors flex items-center justify-center gap-1.5 active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <span>Terapkan Filter</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- ═══ Orders List ═══ --}}
            @if($orders->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach($orders as $order)
                        @php
                            $currentStatus = $order->status;
                            $orderCode = $order->order_code ?? ('#SMC-' . str_pad($order->id, 5, '0', STR_PAD_LEFT));
                            $isPaid = ($order->payment_status === 'paid');
                        @endphp
                        <div class="bg-white border {{ $currentStatus === 'processing' ? 'border-amber-300 ring-2 ring-amber-200/50' : 'border-slate-200' }} rounded-3xl p-5 sm:p-6 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                {{-- Card Header --}}
                                <div class="flex items-start justify-between gap-3 pb-4 border-b border-slate-100">
                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="font-mono font-extrabold text-sm text-primary-800 bg-primary-50 px-2 py-0.5 rounded-lg border border-primary-200">
                                                {{ $orderCode }}
                                            </span>
                                            @if($isPaid)
                                                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center gap-1">
                                                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    LUNAS CASHLESS
                                                </span>
                                            @else
                                                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-rose-100 text-rose-800 border border-rose-200">
                                                    Menunggu Bayar
                                                </span>
                                            @endif
                                        </div>
                                        <h4 class="text-base font-extrabold text-slate-900 mt-2">
                                            {{ $order->user->name ?? 'Siswa' }}
                                        </h4>
                                        <p class="text-xs text-slate-400 mt-0.5">
                                            Dipesan: {{ $order->created_at->format('d M Y, H:i') }} WIB
                                        </p>
                                    </div>

                                    <div class="text-right flex-shrink-0">
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
                                            <div class="flex items-center gap-2.5 min-w-0">
                                                <span class="w-6 h-6 rounded-lg bg-primary-100 text-primary-800 font-extrabold text-xs flex items-center justify-center flex-shrink-0">
                                                    {{ $item->quantity }}x
                                                </span>
                                                <div class="min-w-0">
                                                    <span class="font-bold text-slate-800 truncate block">{{ $item->menu->name ?? 'Menu' }}</span>
                                                    @if($item->notes)
                                                        <span class="text-[11px] text-amber-800 bg-amber-100/70 font-semibold px-2 py-0.5 rounded border border-amber-200 block mt-0.5">
                                                            ↳ {{ $item->notes }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <span class="text-xs font-semibold text-slate-500 flex-shrink-0 ml-2">
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
                                                class="w-full bg-primary-800 hover:bg-primary-900 text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-xs transition-all active:scale-95 flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>Terima &amp; Siapkan Masakan</span>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('penjual.orders.updateStatus', $order) }}"
                                            onsubmit="return confirm('Batalkan pesanan {{ $orderCode }}?')">
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
                                                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-xs transition-all active:scale-95 flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span>Tandai Siap Diambil / Selesai</span>
                                            </button>
                                        </form>
                                    @elseif($currentStatus === 'completed')
                                        <div class="w-full bg-emerald-50 border border-emerald-200 text-emerald-800 px-3.5 py-2 rounded-xl text-xs font-bold flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Pesanan Telah Diambil Siswa</span>
                                        </div>
                                    @elseif($currentStatus === 'cancelled')
                                        <div class="w-full bg-rose-50 border border-rose-200 text-rose-700 px-3.5 py-2 rounded-xl text-xs font-bold flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            <span>Pesanan Dibatalkan</span>
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
                <div class="text-center py-20 px-4 bg-white rounded-3xl border border-slate-200 shadow-xs">
                    <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-slate-800 mb-1">Tidak Ada Pesanan</h3>
                    <p class="text-slate-500 text-xs sm:text-sm max-w-sm mx-auto mb-4">
                        @if(request()->anyFilled(['preset', 'date', 'status', 'payment_status', 'search']))
                            Tidak ditemukan pesanan yang sesuai dengan filter yang dipilih.
                        @else
                            Stand Anda belum memiliki pesanan saat ini. Pesanan baru dari siswa akan langsung muncul secara real-time di sini.
                        @endif
                    </p>
                    @if(request()->anyFilled(['preset', 'date', 'status', 'payment_status', 'search']))
                        <a href="{{ route('penjual.orders.index') }}" class="btn-primary text-xs py-2 px-4 inline-flex items-center gap-1.5">
                            <span>Tampilkan Semua Pesanan</span>
                        </a>
                    @endif
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
