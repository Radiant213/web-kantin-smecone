@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    {{-- Page Title --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1">Overview performa E-Kantin</p>
    </div>

    {{-- ═══ Metric Cards ═══ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Revenue --}}
        <div class="metric-card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-emerald-500 bg-emerald-50 px-2 py-1 rounded-full">Revenue</span>
            </div>
            <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-1">Total pendapatan</p>
        </div>

        {{-- Orders --}}
        <div class="metric-card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-blue-500 bg-blue-50 px-2 py-1 rounded-full">Orders</span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalOrders) }}</p>
            <p class="text-xs text-gray-400 mt-1">Total pesanan</p>
        </div>

        {{-- Active Kiosks --}}
        <div class="metric-card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-primary-500 bg-primary-50 px-2 py-1 rounded-full">Kiosks</span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($activeKiosks) }}</p>
            <p class="text-xs text-gray-400 mt-1">Kios aktif</p>
        </div>

        {{-- Users --}}
        <div class="metric-card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-purple-500 bg-purple-50 px-2 py-1 rounded-full">Users</span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalUsers) }}</p>
            <p class="text-xs text-gray-400 mt-1">Total pembeli</p>
        </div>
    </div>

    {{-- ═══ Charts Row ═══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-8">
        {{-- Sales Overview Chart Placeholder --}}
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-semibold text-gray-800">Sales Overview</h3>
                <span class="text-xs text-gray-400">Minggu Ini</span>
            </div>
            <div
                class="h-48 bg-gradient-to-t from-primary-50 to-transparent rounded-xl flex items-end justify-center gap-3 px-4 pb-4">
                @php $bars = [40, 65, 50, 80, 55, 90, 70];
                $days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']; @endphp
                @foreach($bars as $i => $height)
                    <div class="flex flex-col items-center gap-1 flex-1">
                        <div class="w-full max-w-[32px] bg-gradient-to-t from-primary-500 to-primary-300 rounded-lg transition-all hover:from-primary-600 hover:to-primary-400"
                            style="height: {{ $height }}%"></div>
                        <span class="text-xs text-gray-400">{{ $days[$i] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Pie Chart Placeholder --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-6">Kantin Distribution</h3>
            <div class="flex items-center justify-center h-48">
                <div class="relative w-32 h-32">
                    <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36">
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#fed7aa" stroke-width="3"
                            stroke-dasharray="40 60" />
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#fb923c" stroke-width="3"
                            stroke-dasharray="35 65" stroke-dashoffset="-40" />
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#c2410c" stroke-width="3"
                            stroke-dasharray="25 75" stroke-dashoffset="-75" />
                    </svg>
                </div>
            </div>
            <div class="space-y-2 mt-4">
                @foreach($kantins as $kantin)
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-2.5 h-2.5 rounded-full bg-primary-{{ $loop->first ? '300' : ($loop->last ? '700' : '500') }}">
                            </div>
                            <span class="text-gray-600 text-xs">{{ $kantin->name }}</span>
                        </div>
                        <span class="text-xs font-medium text-gray-700">{{ $kantin->kiosks_count }} kios</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ═══ Recent Orders Table ═══ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}"
                class="text-sm text-primary-500 hover:text-primary-600 font-medium">Lihat Semua →</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3">Pembeli</th>
                        <th class="px-6 py-3">Kios</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentOrders as $order)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center">
                                                    <span
                                                        class="text-xs font-bold text-primary-500">{{ substr($order->user->name, 0, 1) }}</span>
                                                </div>
                                                <span class="text-sm font-medium text-gray-700">{{ $order->user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $order->kiosk->name }}</td>
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $order->formattedTotal() }}</td>
                                        <td class="px-6 py-4">
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
                                                class="{{ $statusColors[$order->status] ?? 'badge' }}">{{ $statusLabels[$order->status] ?? $order->status }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</td>
                                    </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400">Belum ada pesanan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection