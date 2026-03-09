<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pesanan Toko') }}: {{ $kiosk->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Daftar Pesanan Masuk</h3>
                            <p class="text-sm text-gray-500">Kelola pesanan yang masuk ke kios Anda.</p>
                        </div>
                        <a href="{{ route('profile.edit') }}"
                            class="text-sm text-primary-600 hover:text-primary-800 font-medium">Buka Profil Kios</a>
                    </div>

                    @if($orders->count() > 0)
                        <div class="space-y-4">
                            @foreach($orders as $order)
                                <div
                                    class="bg-gray-50 border border-gray-100 rounded-xl p-4 sm:p-6 transition-all hover:shadow-md">
                                    <div
                                        class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-4 pb-4 border-b border-gray-200">
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">ID Pesanan: <span
                                                    class="font-mono font-medium text-gray-700">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                                • {{ $order->created_at->format('d M Y, H:i') }}</p>
                                            <p class="text-sm font-semibold text-gray-800">Pembeli: {{ $order->user->name }}</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'badge-warning',
                                                    'processing' => 'badge-info',
                                                    'completed' => 'badge-success',
                                                    'cancelled' => 'badge-danger',
                                                ];
                                                $statusLabels = [
                                                    'pending' => 'Menunggu Konfirmasi',
                                                    'processing' => 'Diproses',
                                                    'completed' => 'Selesai',
                                                    'cancelled' => 'Dibatalkan',
                                                ];
                                                $currentStatus = $order->status;
                                            @endphp
                                            <span class="{{ $statusColors[$currentStatus] ?? 'badge' }} px-3 py-1 text-xs">
                                                {{ $statusLabels[$currentStatus] ?? $currentStatus }}
                                            </span>
                                            <p class="font-bold text-gray-900 border-l border-gray-300 pl-3">Rp
                                                {{ number_format($order->total_price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-2 mb-6">
                                        @foreach($order->items as $item)
                                            <div class="flex justify-between items-center text-sm">
                                                <div class="flex items-center gap-2">
                                                    <span class="font-medium text-gray-800">{{ $item->quantity }}x</span>
                                                    <span class="text-gray-600">{{ $item->menu->name }}</span>
                                                </div>
                                                <span class="text-gray-500">Rp
                                                    {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Order Actions --}}
                                    <div class="flex flex-wrap gap-2 pt-2 border-t border-gray-100">
                                        @if($currentStatus === 'pending')
                                            <form method="POST" action="{{ route('penjual.orders.updateStatus', $order) }}">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="processing">
                                                <button type="submit"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Terima
                                                    & Proses</button>
                                            </form>
                                            <form method="POST" action="{{ route('penjual.orders.updateStatus', $order) }}"
                                                onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit"
                                                    class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm font-medium transition-colors border border-red-200">Tolak
                                                    Pesanan</button>
                                            </form>
                                        @elseif($currentStatus === 'processing')
                                            <form method="POST" action="{{ route('penjual.orders.updateStatus', $order) }}">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit"
                                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Tandai Selesai / Diambil
                                                </button>
                                            </form>
                                        @elseif($currentStatus === 'completed')
                                            <span
                                                class="text-xs text-green-600 bg-green-50 px-3 py-1.5 rounded-lg border border-green-100 font-medium flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Pesanan telah selesai
                                            </span>
                                        @elseif($currentStatus === 'cancelled')
                                            <span
                                                class="text-xs text-red-600 bg-red-50 px-3 py-1.5 rounded-lg border border-red-100 font-medium flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                Pesanan dibatalkan
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-12 px-4 bg-gray-50 rounded-2xl border border-gray-100 border-dashed">
                            <div
                                class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Belum Ada Pesanan Masuk</h3>
                            <p class="text-gray-500 text-sm max-w-sm mx-auto">Toko Anda belum menerima pesanan apapun saat
                                ini. Pesanan baru akan muncul di sini.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>