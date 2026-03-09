@extends('layouts.admin')

@section('title', 'Kelola Pengajuan Kios')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pengajuan Kios</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola permohonan kepemilikan kios dari penjual</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr
                        class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Calon Penjual</th>
                        <th class="px-6 py-3">Kios yang Diajukan</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($applications as $app)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $app->created_at->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-8 h-8 rounded-xl bg-primary-50 flex items-center justify-center flex-shrink-0">
                                                    <span
                                                        class="text-sm font-bold text-primary-600">{{ substr($app->user->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-800">{{ $app->user->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $app->user->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">{{ $app->kiosk->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $app->kiosk->kantin->name }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'badge-warning',
                                                    'approved' => 'badge-success',
                                                    'rejected' => 'badge-danger',
                                                ];
                                                $statusLabels = [
                                                    'pending' => 'Menunggu',
                                                    'approved' => 'Disetujui',
                                                    'rejected' => 'Ditolak',
                                                ];
                                            @endphp
                        <span
                                                class="{{ $statusColors[$app->status] ?? 'badge' }}">{{ $statusLabels[$app->status] ?? $app->status }}</span>
                                            @if($app->reason)
                                                <p class="text-xs text-red-500 mt-1 max-w-xs truncate" title="{{ $app->reason }}">
                                                    {{ $app->reason }}</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($app->status === 'pending')
                                                <div class="flex items-center gap-2">
                                                    <form method="POST" action="{{ route('admin.kiosk-applications.approve', $app) }}"
                                                        onsubmit="return confirm('Setujui pengajuan ini? Kios akan dialihkan ke penjual ini.')">
                                                        @csrf
                                                        <button type="submit"
                                                            class="text-sm text-green-600 hover:text-green-700 font-medium px-3 py-1 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">Setujui</button>
                                                    </form>

                                                    <button type="button"
                                                        onclick="document.getElementById('reject-modal-{{ $app->id }}').classList.remove('hidden')"
                                                        class="text-sm text-red-600 hover:text-red-700 font-medium px-3 py-1 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">Tolak</button>
                                                </div>

                                                {{-- Reject Modal --}}
                                                <div id="reject-modal-{{ $app->id }}"
                                                    class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                                                    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
                                                        <div class="flex justify-between items-center mb-4">
                                                            <h3 class="text-lg font-bold text-gray-800">Tolak Pengajuan</h3>
                                                            <button type="button"
                                                                onclick="document.getElementById('reject-modal-{{ $app->id }}').classList.add('hidden')"
                                                                class="text-gray-400 hover:text-gray-600">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <form method="POST" action="{{ route('admin.kiosk-applications.reject', $app) }}">
                                                            @csrf
                                                            <div class="mb-4">
                                                                <label class="block text-sm font-medium text-gray-700 mb-1">Alasan
                                                                    Penolakan</label>
                                                                <textarea name="reason" rows="3" class="input-field" required
                                                                    placeholder="Tulis alasan penolakan..."></textarea>
                                                            </div>
                                                            <div class="flex justify-end gap-3">
                                                                <button type="button"
                                                                    onclick="document.getElementById('reject-modal-{{ $app->id }}').classList.add('hidden')"
                                                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
                                                                <button type="submit"
                                                                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-xl transition-colors">Konfirmasi
                                                                    Tolak</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-xs text-gray-400">Sudah diproses</span>
                                            @endif
                                        </td>
                                    </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400">Belum ada pengajuan kios</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $applications->links() }}
        </div>
    </div>
@endsection