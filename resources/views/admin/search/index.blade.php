@extends('layouts.admin')

@section('title', 'Hasil Pencarian')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Cari: "{{ $query }}"</h1>
        <p class="text-sm text-gray-500 mt-1">Menampilkan hasil pencarian untuk "{{ $query }}"</p>
    </div>

    <div class="space-y-8">
        {{-- Kantin Results --}}
        <div>
            <h2 class="text-lg font-bold text-gray-700 mb-4 border-b border-gray-100 pb-2 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Kantin ({{ $kantins->count() }})
            </h2>
            @if($kantins->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($kantins as $kantin)
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                            <span class="font-medium text-gray-800">{{ $kantin->name }}</span>
                            <a href="{{ route('admin.kantins.edit', $kantin->id) }}"
                                class="text-xs text-primary-500 hover:underline">Edit</a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400 italic">Tidak ada kantin yang cocok.</p>
            @endif
        </div>

        {{-- Kiosks Results --}}
        <div>
            <h2 class="text-lg font-bold text-gray-700 mb-4 border-b border-gray-100 pb-2 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h18v18H3zM12 8v4m0 4h.01" />
                </svg>
                Kiosks ({{ $kiosks->count() }})
            </h2>
            @if($kiosks->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($kiosks as $kiosk)
                        <div
                            class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <p class="font-medium text-gray-800 truncate">{{ $kiosk->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $kiosk->kantin->name ?? 'Tanpa Kantin' }}</p>
                            </div>
                            <a href="{{ route('admin.kiosks.edit', $kiosk->id) }}"
                                class="text-xs text-primary-500 hover:underline flex-shrink-0">Edit</a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400 italic">Tidak ada kios yang cocok.</p>
            @endif
        </div>

        {{-- Users Results --}}
        <div>
            <h2 class="text-lg font-bold text-gray-700 mb-4 border-b border-gray-100 pb-2 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Users ({{ $users->count() }})
            </h2>
            @if($users->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($users as $user)
                        <div
                            class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-gray-800 truncate">{{ $user->name }}</span>
                                    @if($user->isAdmin())
                                        <span
                                            class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-primary-50 text-primary-600">Admin</span>
                                    @elseif($user->isPenjual())
                                        <span
                                            class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-600">Penjual</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                            </div>
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                class="text-xs text-primary-500 hover:underline flex-shrink-0">Edit</a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400 italic">Tidak ada pengguna yang cocok.</p>
            @endif
        </div>
    </div>
@endsection