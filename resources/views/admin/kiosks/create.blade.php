@extends('layouts.admin')

@section('title', 'Tambah Kios')

@section('content')
    <div class="max-w-2xl">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.kiosks.index') }}"
                class="flex items-center justify-center w-10 h-10 rounded-xl bg-gray-100 hover:bg-primary-100 text-gray-600 hover:text-primary-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Kios</h1>
        </div>

        <form method="POST" action="{{ route('admin.kiosks.store') }}" enctype="multipart/form-data"
            class="card p-6 space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kios</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="input-field" required>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="kantin_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Kantin</label>
                    <select name="kantin_id" id="kantin_id" class="input-field" required>
                        <option value="">-- Pilih Kantin --</option>
                        @foreach($kantins as $kantin)
                            <option value="{{ $kantin->id }}" {{ old('kantin_id') == $kantin->id ? 'selected' : '' }}>
                                {{ $kantin->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('kantin_id')" class="mt-2" />
                </div>
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Penjual (Pemilik Kios)</label>
                    <select name="user_id" id="user_id" class="input-field" required>
                        <option value="">-- Pilih Penjual --</option>
                        @foreach($penjuals as $penjual)
                            <option value="{{ $penjual->id }}" {{ old('user_id') == $penjual->id ? 'selected' : '' }}>
                                {{ $penjual->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi /
                    Spesialisasi</label>
                <textarea id="description" name="description" rows="3"
                    class="input-field">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Cover</label>
                <input type="file" id="image" name="image" accept="image/*" class="input-field">
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>
            <button type="submit" class="btn-primary">Simpan Kios</button>
        </form>
    </div>
@endsection