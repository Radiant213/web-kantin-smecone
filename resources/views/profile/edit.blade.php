<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">

        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">Pengaturan Akun</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola informasi profil dan keamanan akun Anda.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 md:gap-8" x-data="{ activeTab: '{{ session('status') === 'password-updated' ? 'password' : 'profile' }}' }">

            {{-- ═══ Left Column: Tab Navigation ═══ --}}
            <div class="lg:col-span-1 flex-shrink-0">
                <nav class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-3 space-y-1 sticky top-24">
                    <button @click="activeTab = 'profile'"
                        :class="activeTab === 'profile' ? 'bg-primary-50 text-primary-800 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800'"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all duration-200">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Profil Saya</span>
                    </button>

                    <button @click="activeTab = 'password'"
                        :class="activeTab === 'password' ? 'bg-primary-50 text-primary-800 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800'"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all duration-200">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span>Ubah Password</span>
                    </button>
                </nav>
            </div>

            {{-- ═══ Right Column: Content Area ═══ --}}
            <div class="lg:col-span-3 min-w-0">

                {{-- ══ Tab 1: Profile Information ══ --}}
                <div x-show="activeTab === 'profile'" x-transition.opacity.duration.200ms>
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-primary-50 to-amber-50">
                            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Informasi Profil
                            </h2>
                            <p class="mt-1 text-sm text-slate-500">Perbarui nama dan alamat email akun Anda.</p>
                        </div>

                        <div class="p-6">
                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>

                            <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
                                @csrf
                                @method('patch')

                                {{-- Avatar --}}
                                <div class="flex items-center gap-4 pb-5 border-b border-slate-100">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-2xl object-cover shadow-md border-2 border-primary-100">
                                    @else
                                        <div class="w-16 h-16 bg-gradient-to-br from-primary-700 to-primary-900 rounded-2xl flex items-center justify-center shadow-md text-white text-2xl font-bold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-900">{{ $user->name }}</h3>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold
                                            @if($user->role === 'admin') bg-purple-100 text-purple-700
                                            @elseif($user->role === 'penjual') bg-amber-100 text-amber-700
                                            @else bg-sky-100 text-sky-700 @endif">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Lengkap</label>
                                    <input id="name" name="name" type="text"
                                        class="w-full border-slate-200 focus:border-primary-700 focus:ring-primary-700/20 rounded-xl shadow-sm transition-colors px-4 py-3 text-sm"
                                        value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>

                                <div>
                                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Alamat Email</label>
                                    <input id="email" name="email" type="email"
                                        class="w-full border-slate-200 focus:border-primary-700 focus:ring-primary-700/20 rounded-xl shadow-sm transition-colors px-4 py-3 text-sm"
                                        value="{{ old('email', $user->email) }}" required autocomplete="username">
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                        <div class="mt-2">
                                            <p class="text-sm text-slate-800">
                                                Email belum terverifikasi.
                                                <button form="send-verification" class="underline text-sm text-primary-700 hover:text-primary-800">
                                                    Kirim ulang link verifikasi.
                                                </button>
                                            </p>
                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-2 font-medium text-sm text-emerald-600">Link verifikasi baru telah dikirim.</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                                    <button type="submit" class="btn-primary text-sm py-2.5">Simpan Perubahan</button>
                                    @if (session('status') === 'profile-updated')
                                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                            class="text-sm text-emerald-600 font-bold">✓ Tersimpan!</p>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ══ Tab 2: Update Password ══ --}}
                <div x-show="activeTab === 'password'" x-transition.opacity.duration.200ms x-cloak>
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-sky-50 to-indigo-50">
                            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Ubah Password
                            </h2>
                            <p class="mt-1 text-sm text-slate-500">Gunakan password yang kuat dan unik untuk keamanan akun.</p>
                        </div>

                        <div class="p-6">
                            <form method="post" action="{{ route('password.update') }}" class="space-y-5">
                                @csrf
                                @method('put')

                                <div>
                                    <label for="update_password_current_password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Password Saat Ini</label>
                                    <input id="update_password_current_password" name="current_password" type="password"
                                        class="w-full border-slate-200 focus:border-primary-700 focus:ring-primary-700/20 rounded-xl shadow-sm transition-colors px-4 py-3 text-sm"
                                        autocomplete="current-password">
                                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="update_password_password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Password Baru</label>
                                    <input id="update_password_password" name="password" type="password"
                                        class="w-full border-slate-200 focus:border-primary-700 focus:ring-primary-700/20 rounded-xl shadow-sm transition-colors px-4 py-3 text-sm"
                                        autocomplete="new-password">
                                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="update_password_password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
                                    <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                                        class="w-full border-slate-200 focus:border-primary-700 focus:ring-primary-700/20 rounded-xl shadow-sm transition-colors px-4 py-3 text-sm"
                                        autocomplete="new-password">
                                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                                </div>

                                <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                                    <button type="submit" class="btn-primary text-sm py-2.5">Perbarui Password</button>
                                    @if (session('status') === 'password-updated')
                                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                            class="text-sm text-emerald-600 font-bold">✓ Password diperbarui!</p>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
