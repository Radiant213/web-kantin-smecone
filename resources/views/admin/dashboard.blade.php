@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
    {{-- Page Title --}}
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Dashboard Overview</h1>
        <p class="text-sm text-slate-500 mt-1">Ringkasan performa dan metrik operasional E-Kantin SMECONE</p>
    </div>

    {{-- ═══ Metric Cards ═══ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Revenue --}}
        <div class="metric-card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shadow-inner">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-full">Pendapatan</span>
            </div>
            <p class="text-2xl font-extrabold text-slate-900 tracking-tight">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-1">Total transaksi lunas</p>
        </div>

        {{-- Orders --}}
        <div class="metric-card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shadow-inner">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-blue-700 bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-full">Pesanan</span>
            </div>
            <p class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ number_format($totalOrders) }}</p>
            <p class="text-xs text-slate-400 mt-1">Total seluruh pesanan</p>
        </div>

        {{-- Active Kiosks --}}
        <div class="metric-card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-700 flex items-center justify-center shadow-inner">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-red-700 bg-red-50 border border-red-100 px-2.5 py-1 rounded-full">Stand Kios</span>
            </div>
            <p class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ number_format($activeKiosks) }}</p>
            <p class="text-xs text-slate-400 mt-1">Kios terdaftar aktif</p>
        </div>

        {{-- Users --}}
        <div class="metric-card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center shadow-inner">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-purple-700 bg-purple-50 border border-purple-100 px-2.5 py-1 rounded-full">Siswa</span>
            </div>
            <p class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ number_format($totalUsers) }}</p>
            <p class="text-xs text-slate-400 mt-1">Akun pembeli terdaftar</p>
        </div>
    </div>

    {{-- ═══ Charts Row ═══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Sales Overview Chart --}}
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-bold text-slate-800">Aktivitas Pesanan Harian</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Frekuensi pesanan per hari dalam minggu ini</p>
                </div>
                <span class="text-xs font-semibold text-red-700 bg-red-50 border border-red-100 px-2.5 py-1 rounded-full">Minggu Ini</span>
            </div>
            <div
                class="h-52 bg-slate-50/70 border border-slate-100 rounded-2xl flex items-end justify-center gap-3 sm:gap-4 px-4 pb-4">
                @php
                    $bars = [40, 65, 50, 80, 55, 90, 70];
                    $days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
                @endphp
                @foreach($bars as $i => $height)
                    <div class="flex flex-col items-center gap-1.5 flex-1">
                        <div class="w-full max-w-[36px] bg-gradient-to-t from-red-700 to-red-400 rounded-xl transition-all duration-300 hover:from-red-800 hover:to-red-500 shadow-sm"
                            style="height: {{ $height }}%"></div>
                        <span class="text-[11px] font-semibold text-slate-500">{{ $days[$i] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Kantin Distribution --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80 flex flex-col justify-between">
            <div>
                <h3 class="font-bold text-slate-800">Distribusi Kios Kantin</h3>
                <p class="text-xs text-slate-400 mt-0.5">Penyebaran stand kios di area sekolah</p>
            </div>
            <div class="flex items-center justify-center my-4">
                <div class="relative w-32 h-32">
                    <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36">
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#fca5a5" stroke-width="3"
                            stroke-dasharray="40 60" />
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#ef4444" stroke-width="3"
                            stroke-dasharray="35 65" stroke-dashoffset="-40" />
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#991b1b" stroke-width="3"
                            stroke-dasharray="25 75" stroke-dashoffset="-75" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-lg font-black text-slate-800 leading-none">{{ $activeKiosks }}</span>
                        <span class="text-[10px] text-slate-400 font-bold uppercase mt-0.5">Total Kios</span>
                    </div>
                </div>
            </div>
            <div class="space-y-2.5 pt-2 border-t border-slate-100">
                @php
                    $colors = ['bg-rose-400', 'bg-red-500', 'bg-red-800', 'bg-amber-500'];
                @endphp
                @foreach($kantins as $kantin)
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2.5">
                            <span class="w-3 h-3 rounded-full {{ $colors[$loop->index % count($colors)] }} flex-shrink-0"></span>
                            <span class="text-slate-700 text-xs font-semibold">{{ $kantin->name }}</span>
                        </div>
                        <span class="text-xs font-bold text-slate-800 bg-slate-100 px-2 py-0.5 rounded-lg">{{ $kantin->kiosks_count }} kios</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ═══ Recent Orders Table ═══ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900">Pesanan Terbaru</h3>
                <p class="text-xs text-slate-400 mt-0.5">Daftar transaksi pesanan terakhir yang masuk</p>
            </div>
            <a href="{{ route('admin.orders.index') }}"
                class="inline-flex items-center gap-1.5 text-xs font-bold text-red-700 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-xl transition-colors">
                Lihat Semua
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/70 border-b border-slate-100">
                        <th class="px-6 py-3.5">Kode & Pembeli</th>
                        <th class="px-6 py-3.5">Stand Kios</th>
                        <th class="px-6 py-3.5">Total Harga</th>
                        <th class="px-6 py-3.5">Status Pembayaran</th>
                        <th class="px-6 py-3.5">Status Pesanan</th>
                        <th class="px-6 py-3.5">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-red-100 text-red-800 font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-inner">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 leading-tight">{{ $order->user->name }}</p>
                                        <p class="text-[11px] font-mono text-slate-400 mt-0.5">#{{ $order->order_code ?? $order->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold text-slate-700">{{ $order->kiosk->name ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-extrabold text-slate-900">{{ $order->formattedTotal() }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($order->payment_status === 'paid')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        LUNAS
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
                                        BELUM LUNAS
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusMap = [
                                        'pending' => ['label' => 'Menunggu', 'class' => 'bg-amber-50 text-amber-700 border-amber-200'],
                                        'processing' => ['label' => 'Diproses Stand', 'class' => 'bg-blue-50 text-blue-700 border-blue-200'],
                                        'completed' => ['label' => 'Selesai', 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                                        'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-rose-50 text-rose-700 border-rose-200'],
                                    ];
                                    $st = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'bg-slate-100 text-slate-700 border-slate-200'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $st['class'] }}">
                                    {{ $st['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-400 font-medium">
                                {{ $order->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-xs text-slate-400">
                                Belum ada pesanan yang tercatat di sistem.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
