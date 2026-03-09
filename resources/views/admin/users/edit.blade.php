@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div class="max-w-xl">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.users.index') }}"
                class="flex items-center justify-center w-10 h-10 rounded-xl bg-gray-100 hover:bg-primary-100 text-gray-600 hover:text-primary-500 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Edit User: {{ $user->name }}</h1>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="card p-6 space-y-6">
            @csrf @method('PUT')
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="input-field"
                    required>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="input-field"
                    required>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" id="role" class="input-field" required {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                    <option value="pembeli" {{ old('role', $user->role) == 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                    <option value="penjual" {{ old('role', $user->role) == 'penjual' ? 'selected' : '' }}>Penjual</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @if($user->id === auth()->id())
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <p class="text-xs text-gray-500 mt-1">Anda tidak dapat mengubah role akun Anda sendiri.</p>
                @endif
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="pt-4 border-t border-gray-100 mt-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Ubah Password (Opsional)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input type="password" id="password" name="password" class="input-field"
                            placeholder="Kosongkan jika tidak diubah">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi
                            Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="input-field">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-primary w-full mt-6">Simpan Perubahan</button>
        </form>
    </div>
@endsection