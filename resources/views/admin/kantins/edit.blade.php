@extends('layouts.admin')

@section('title', 'Edit Kantin')

@section('content')
    <div class="max-w-2xl">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.kantins.index') }}"
                class="flex items-center justify-center w-10 h-10 rounded-xl bg-gray-100 hover:bg-primary-100 text-gray-600 hover:text-primary-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Edit Kantin: {{ $kantin->name }}</h1>
        </div>

        <form method="POST" action="{{ route('admin.kantins.update', $kantin) }}" enctype="multipart/form-data"
            class="card p-6 space-y-6">
            @csrf @method('PUT')
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kantin</label>
                <input type="text" id="name" name="name" value="{{ old('name', $kantin->name) }}" class="input-field"
                    required>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea id="description" name="description" rows="3"
                    class="input-field">{{ old('description', $kantin->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
                <input type="file" id="image" name="image" accept="image/*" class="input-field">
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </form>
    </div>
@endsection