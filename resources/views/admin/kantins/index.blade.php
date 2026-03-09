@extends('layouts.admin')

@section('title', 'Kelola Kantin')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Kantin</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $kantins->count() }} kantin terdaftar</p>
        </div>
        <a href="{{ route('admin.kantins.create') }}" class="btn-primary-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Kantin
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr
                        class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Nama Kantin</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Jumlah Kios</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($kantins as $kantin)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $kantin->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $kantin->description ?? '-' }}</td>
                            <td class="px-6 py-4"><span class="badge-info">{{ $kantin->kiosks_count }} kios</span></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.kantins.edit', $kantin) }}"
                                        class="text-sm text-primary-500 hover:text-primary-600 font-medium">Edit</a>
                                    <form method="POST" action="{{ route('admin.kantins.destroy', $kantin) }}"
                                        onsubmit="return confirm('Yakin hapus kantin ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-sm text-red-500 hover:text-red-600 font-medium">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400">Belum ada kantin</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection