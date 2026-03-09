@extends('layouts.admin')

@section('title', 'Kelola Kios')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Kios</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $kiosks->count() }} kios terdaftar</p>
        </div>
        <a href="{{ route('admin.kiosks.create') }}" class="btn-primary-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Kios
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-3">Nama Kios</th>
                        <th class="px-6 py-3">Kantin</th>
                        <th class="px-6 py-3">Penjual</th>
                        <th class="px-6 py-3">Menu</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($kiosks as $kiosk)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center overflow-hidden flex-shrink-0">
                                        @if($kiosk->image)
                                            <img src="{{ asset('storage/' . $kiosk->image) }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-5 h-5 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $kiosk->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $kiosk->kantin->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $kiosk->user->name }}</td>
                            <td class="px-6 py-4"><span class="badge-primary">{{ $kiosk->menus->count() }} menu</span></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.kiosks.edit', $kiosk) }}" class="text-sm text-primary-500 hover:text-primary-600 font-medium">Edit</a>
                                    <form method="POST" action="{{ route('admin.kiosks.destroy', $kiosk) }}" onsubmit="return confirm('Yakin hapus kios ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-sm text-red-500 hover:text-red-600 font-medium">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400">Belum ada kios</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
