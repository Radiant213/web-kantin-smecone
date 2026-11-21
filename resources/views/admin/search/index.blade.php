@extends('layouts.admin')

@section('title', 'Hasil Pencarian')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pencarian: "{{ $query }}"</h1>
            <p class="text-sm text-slate-500 mt-0.5">Menampilkan hasil temuan untuk kata kunci "{{ $query }}"</p>
        </div>
        <a href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-red-700 bg-white border border-slate-200 px-3.5 py-2 rounded-xl shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali ke Overview
        </a>
    </div>

    <div class="space-y-8">
        {{-- Kantin Results --}}
        <div>
            <h2 class="text-base font-bold text-slate-800 mb-3.5 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                Kantin ({{ $kantins->count() }})
            </h2>
            @if($kantins->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($kantins as $kantin)
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between hover:border-red-200 transition-all">
                            <span class="font-bold text-slate-800 text-sm">{{ $kantin->name }}</span>
                            <a href="{{ route('admin.kantins.edit', $kantin->id) }}"
                                class="text-xs font-bold text-red-700 hover:text-red-800 bg-red-50 px-2.5 py-1 rounded-lg">Edit</a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-slate-400 italic">Tidak ada kantin yang cocok.</p>
            @endif
        </div>

        {{-- Kiosks Results --}}
        <div>
            <h2 class="text-base font-bold text-slate-800 mb-3.5 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                Stand Kios ({{ $kiosks->count() }})
            </h2>
            @if($kiosks->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($kiosks as $kiosk)
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between gap-3 hover:border-red-200 transition-all">
                            <div class="min-w-0">
                                <p class="font-bold text-slate-800 text-sm truncate">{{ $kiosk->name }}</p>
                                <p class="text-xs text-slate-400 truncate mt-0.5">{{ $kiosk->kantin->name ?? 'Tanpa Kantin' }}</p>
                            </div>
                            <a href="{{ route('admin.kiosks.edit', $kiosk->id) }}"
                                class="text-xs font-bold text-red-700 hover:text-red-800 bg-red-50 px-2.5 py-1 rounded-lg flex-shrink-0">Edit</a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-slate-400 italic">Tidak ada kios yang cocok.</p>
            @endif
        </div>

        {{-- Users Results --}}
        <div>
            <h2 class="text-base font-bold text-slate-800 mb-3.5 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                Pengguna (Users) ({{ $users->count() }})
            </h2>
            @if($users->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($users as $user)
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between gap-3 hover:border-red-200 transition-all">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-800 text-sm truncate">{{ $user->name }}</span>
                                    @if($user->isAdmin())
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700">Admin</span>
                                    @elseif($user->isPenjual())
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Penjual</span>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-400 truncate mt-0.5">{{ $user->email }}</p>
                            </div>
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                class="text-xs font-bold text-red-700 hover:text-red-800 bg-red-50 px-2.5 py-1 rounded-lg flex-shrink-0">Edit</a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-slate-400 italic">Tidak ada pengguna yang cocok.</p>
            @endif
        </div>
    </div>
@endsection
