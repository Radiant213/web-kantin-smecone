@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Pesanan</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $orders->count() }} pesanan masuk</p>
        </div>
    </div>

    {{-- Filter/Search Placeholder --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6 flex flex-wrap gap-4 items-center">
        <select class="input-field max-w-xs">
            <option value="">Semua Status</option>
            <option value="pending">Menunggu</option>
            <option value="processing">Diproses</option>
            <option value="completed">Selesai</option>
            <option value="cancelled">Dibatalkan</option>
        </select>
        <div class="flex-1"></div>
        <div class="text-sm text-gray-500">
            Menampilkan {{ $orders->count() }} pesanan
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr
                        class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-3">Order ID</th>
                        <th class="px-6 py-3">Pembeli</th>
                        <th class="px-6 py-3">Kios</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Waktu</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-800">#{{ $order->id }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-6 h-6 rounded-md bg-primary-50 flex items-center justify-center flex-shrink-0">
                                                    <span
                                                        class="text-[10px] font-bold text-primary-600">{{ substr($order->user->name, 0, 1) }}</span>
                                                </div>
                                                <span class="text-sm font-medium text-gray-700">{{ $order->user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $order->kiosk->name }}</td>
                                        <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $order->formattedTotal() }}</td>
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
                                        <td class="px-6 py-4 text-xs text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                                class="text-sm text-primary-500 hover:text-primary-600 font-medium">Detail</a>
                                        </td>
                                    </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-400">Belum ada pesanan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $orders->links() }}
        </div>
    </div>
@endsection