<x-app-layout>
    @section('title', 'Profil Saya')

    @section('content')
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12" x-data="{ 
                                    activeTab: '{{ session('status') === 'password-updated' ? 'password' : 'profile' }}',
                                    darkMode: localStorage.getItem('theme') === 'dark',
                                    audioEnabled: localStorage.getItem('audioEnabled') === 'true',
                                    currentOrder: null,
                                    showOrderModal: false,

                                    toggleDark() {
                                        this.darkMode = !this.darkMode;
                                        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                                        if (this.darkMode) {
                                            document.documentElement.classList.add('dark');
                                        } else {
                                            document.documentElement.classList.remove('dark');
                                        }
                                    },

                                    @if(auth()->user()->isPenjual())
                                        toggleAudio() {
                                            this.audioEnabled = !this.audioEnabled;
                                            localStorage.setItem('audioEnabled', this.audioEnabled ? 'true' : 'false');
                                            if(this.audioEnabled) {
                                                // Request browser notification permission
                                                if ('Notification' in window && Notification.permission === 'default') {
                                                    Notification.requestPermission();
                                                }
                                                if(!window.orderAudio) {
                                                    window.orderAudio = new Audio('/sounds/notification.mp3');
                                                }
                                                window.orderAudio.volume = 0.8;
                                                window.orderAudio.play().then(() => {
                                                    window.orderAudio.pause();
                                                    window.orderAudio.currentTime = 0;
                                                }).catch(e => console.error('Audio unlock failed:', e));
                                            }
                                        },
                                        acceptOrder() {
                                            if(window.orderAudio) {
                                                window.orderAudio.pause();
                                                window.orderAudio.currentTime = 0;
                                            }
                                            this.showOrderModal = false;
                                            window.location.href = '{{ route('penjual.orders.index') }}';
                                        }
                                    @endif
                                }" x-init="if (darkMode) document.documentElement.classList.add('dark');">

            {{-- Page Header --}}
            <div class="mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Pengaturan Akun</h1>
                <p class="mt-1 text-sm text-gray-500">Kelola informasi profil dan keamanan akun Anda.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 md:gap-8">

                {{-- ═══ Left Column: Tab Navigation ═══ --}}
                <div class="lg:col-span-1 flex-shrink-0">
                    <nav class="bg-white rounded-2xl shadow-sm border border-gray-100 p-3 space-y-1 sticky top-24">
                        {{-- Profile Tab --}}
                        <button @click="activeTab = 'profile'"
                            :class="activeTab === 'profile' ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all duration-200">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Profil Saya</span>
                        </button>

                        {{-- Kiosk Management Tab (Penjual Only) --}}
                        @if(auth()->user()->isPenjual())
                            <button @click="activeTab = 'kiosk'"
                                :class="activeTab === 'kiosk' ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800'"
                                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all duration-200">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                <span>Manajemen Kios</span>
                            </button>
                        @endif

                        {{-- Password Tab --}}
                        <button @click="activeTab = 'password'"
                            :class="activeTab === 'password' ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all duration-200">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            <span>Ubah Password</span>
                        </button>

                        {{-- Settings Tab --}}
                        <button @click="activeTab = 'settings'"
                            :class="activeTab === 'settings' ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all duration-200">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Pengaturan</span>
                        </button>
                    </nav>
                </div>

                {{-- ═══ Right Column: Content Area ═══ --}}
                <div class="lg:col-span-3 min-w-0">

                    {{-- ══ Tab 1: Profile Information ══ --}}
                    <div x-show="activeTab === 'profile'" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            {{-- Card Header --}}
                            <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-primary-50 to-orange-50">
                                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Informasi Profil
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">Perbarui nama dan alamat email akun Anda.</p>
                            </div>

                            {{-- Card Body --}}
                            <div class="p-6">
                                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                    @csrf
                                </form>

                                <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
                                    @csrf
                                    @method('patch')

                                    {{-- User Avatar / Role Badge --}}
                                    <div class="flex items-center gap-4 pb-5 border-b border-gray-100">
                                        <div
                                            class="w-16 h-16 bg-gradient-to-br from-primary-400 to-primary-600 rounded-2xl flex items-center justify-center shadow-md text-white text-2xl font-bold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900">{{ $user->name }}</h3>
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium
                                                                        @if($user->role === 'admin') bg-purple-100 text-purple-700
                                                                        @elseif($user->role === 'penjual') bg-amber-100 text-amber-700
                                                                        @else bg-blue-100 text-blue-700 @endif">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama
                                            Lengkap</label>
                                        <input id="name" name="name" type="text"
                                            class="w-full border-gray-200 focus:border-primary-400 focus:ring-primary-400 rounded-xl shadow-sm transition-colors duration-200 px-4 py-2.5"
                                            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat
                                            Email</label>
                                        <input id="email" name="email" type="email"
                                            class="w-full border-gray-200 focus:border-primary-400 focus:ring-primary-400 rounded-xl shadow-sm transition-colors duration-200 px-4 py-2.5"
                                            value="{{ old('email', $user->email) }}" required autocomplete="username">
                                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-800">
                                                    {{ __('Your email address is unverified.') }}
                                                    <button form="send-verification"
                                                        class="underline text-sm text-primary-600 hover:text-primary-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                                        {{ __('Click here to re-send the verification email.') }}
                                                    </button>
                                                </p>

                                                @if (session('status') === 'verification-link-sent')
                                                    <p class="mt-2 font-medium text-sm text-green-600">
                                                        {{ __('A new verification link has been sent to your email address.') }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                                        <button type="submit"
                                            class="inline-flex items-center px-5 py-2.5 bg-primary-500 border border-transparent rounded-xl font-semibold text-sm text-white tracking-wide hover:bg-primary-600 focus:bg-primary-600 active:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                                            Simpan Perubahan
                                        </button>

                                        @if (session('status') === 'profile-updated')
                                            <p x-data="{ show: true }" x-show="show" x-transition
                                                x-init="setTimeout(() => show = false, 2000)"
                                                class="text-sm text-green-600 font-medium">
                                                ✓ Tersimpan!
                                            </p>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- ══ Tab 2: Kiosk Management (Penjual Only) ══ --}}
                    @if(auth()->user()->isPenjual())
                        <div x-show="activeTab === 'kiosk'" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                                {{-- Card Header --}}
                                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-amber-50 to-orange-50">
                                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                        Manajemen Kios & Menu
                                    </h2>
                                    <p class="mt-1 text-sm text-gray-500">Kelola kios dan menu dagangan Anda.</p>
                                </div>

                                {{-- Card Body --}}
                                <div class="p-6">
                                    <x-penjual.kiosk-manager />
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- ══ Tab 3: Update Password ══ --}}
                    <div x-show="activeTab === 'password'" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            {{-- Card Header --}}
                            <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                    Ubah Password
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">Gunakan password yang kuat dan unik untuk keamanan
                                    akun.</p>
                            </div>

                            {{-- Card Body --}}
                            <div class="p-6">
                                <form method="post" action="{{ route('password.update') }}" class="space-y-5">
                                    @csrf
                                    @method('put')

                                    <div>
                                        <label for="update_password_current_password"
                                            class="block text-sm font-semibold text-gray-700 mb-1.5">Password Saat
                                            Ini</label>
                                        <input id="update_password_current_password" name="current_password" type="password"
                                            class="w-full border-gray-200 focus:border-primary-400 focus:ring-primary-400 rounded-xl shadow-sm transition-colors duration-200 px-4 py-2.5"
                                            autocomplete="current-password">
                                        <x-input-error :messages="$errors->updatePassword->get('current_password')"
                                            class="mt-2" />
                                    </div>

                                    <div>
                                        <label for="update_password_password"
                                            class="block text-sm font-semibold text-gray-700 mb-1.5">Password Baru</label>
                                        <input id="update_password_password" name="password" type="password"
                                            class="w-full border-gray-200 focus:border-primary-400 focus:ring-primary-400 rounded-xl shadow-sm transition-colors duration-200 px-4 py-2.5"
                                            autocomplete="new-password">
                                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                    </div>

                                    <div>
                                        <label for="update_password_password_confirmation"
                                            class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password
                                            Baru</label>
                                        <input id="update_password_password_confirmation" name="password_confirmation"
                                            type="password"
                                            class="w-full border-gray-200 focus:border-primary-400 focus:ring-primary-400 rounded-xl shadow-sm transition-colors duration-200 px-4 py-2.5"
                                            autocomplete="new-password">
                                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')"
                                            class="mt-2" />
                                    </div>

                                    <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                                        <button type="submit"
                                            class="inline-flex items-center px-5 py-2.5 bg-primary-500 border border-transparent rounded-xl font-semibold text-sm text-white tracking-wide hover:bg-primary-600 focus:bg-primary-600 active:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                                            Perbarui Password
                                        </button>

                                        @if (session('status') === 'password-updated')
                                            <p x-data="{ show: true }" x-show="show" x-transition
                                                x-init="setTimeout(() => show = false, 2000)"
                                                class="text-sm text-green-600 font-medium">
                                                ✓ Password diperbarui!
                                            </p>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- ══ Tab 4: Settings ══ --}}
                    <div x-show="activeTab === 'settings'" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            {{-- Card Header --}}
                            <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-teal-50 to-emerald-50">
                                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Pengaturan Global
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">Atur preferensi tampilan dan notifikasi Anda.</p>
                            </div>

                            {{-- Card Body --}}
                            <div class="p-6 space-y-8">
                                {{-- Section: Theme --}}
                                <div>
                                    <h3 class="text-md font-semibold text-gray-800 border-b border-gray-100 pb-2 mb-4">Tema
                                        Tampilan</h3>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-700">Mode Gelap (Dark Mode)</p>
                                            <p class="text-xs text-gray-500">Ubah tampilan menjadi warna gelap agar lebih
                                                ramah di mata saat malam.</p>
                                        </div>
                                        <button @click="toggleDark()"
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                                            :class="darkMode ? 'bg-primary-500' : 'bg-gray-200'" role="switch"
                                            aria-checked="false">
                                            <span aria-hidden="true"
                                                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                                :class="darkMode ? 'translate-x-5' : 'translate-x-0'"></span>
                                        </button>
                                    </div>
                                </div>

                                {{-- Section: Notifications (Penjual Only) --}}
                                @if(auth()->user()->isPenjual())
                                    <div>
                                        <h3 class="text-md font-semibold text-gray-800 border-b border-gray-100 pb-2 mb-4">
                                            Notifikasi Pesanan Kios</h3>
                                        <div class="flex items-center justify-between">
                                            <div class="pr-8">
                                                <p class="text-sm font-medium text-gray-700">Aktifkan Suara</p>
                                                <p class="text-xs text-gray-500">Nyalakan fitur ini jika ingin ada bunyi
                                                    peringatan saat ada pesanan baru masuk ke kios Anda.</p>
                                            </div>
                                            <button @click="toggleAudio()"
                                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                                                :class="audioEnabled ? 'bg-primary-500' : 'bg-gray-200'" role="switch"
                                                aria-checked="false">
                                                <span aria-hidden="true"
                                                    class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                                    :class="audioEnabled ? 'translate-x-5' : 'translate-x-0'"></span>
                                            </button>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ══ Modal Notifikasi Pesanan Baru ══ --}}
            @if(auth()->user()->isPenjual())
                <div x-show="showOrderModal" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true"
                    x-cloak>
                    <div x-show="showOrderModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>

                    <div class="fixed inset-0 z-10 w-screen overflow-y-auto mt-20">
                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                            <div x-show="showOrderModal" x-transition:enter="ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                x-transition:leave="ease-in duration-200"
                                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all border-4 border-primary-500 sm:my-8 sm:w-full sm:max-w-lg">
                                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 text-center">
                                    <div
                                        class="mx-auto flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full bg-primary-100 sm:mx-auto sm:h-20 sm:w-20 mb-4 animate-bounce">
                                        <svg class="h-10 w-10 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold leading-6 text-gray-900" id="modal-title">Ada Pesanan Baru
                                            Masuk!</h3>
                                        <div class="mt-4 bg-gray-50 rounded-xl p-4 border border-gray-100 text-left">
                                            <p class="text-sm font-medium text-gray-500">Subtotal: <span
                                                    class="font-bold text-lg text-primary-600 ml-2"
                                                    x-text="currentOrder ? 'Rp ' + Number(currentOrder.total_price).toLocaleString('id-ID') : 'Rp 0'"></span>
                                            </p>
                                            <p class="text-xs text-gray-400 mt-2">Silakan cek halaman Pesanan Toko untuk detail
                                                item.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-3">
                                    <button type="button" @click="acceptOrder()"
                                        class="inline-flex w-full justify-center rounded-xl bg-primary-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 sm:w-auto transition-colors">Lihat
                                        & Terima Pesanan</button>
                                    <button type="button"
                                        @click="showOrderModal = false; if(window.orderAudio) { window.orderAudio.pause(); window.orderAudio.currentTime = 0; }"
                                        class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">Tutup
                                        Sementara</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endsection
</x-app-layout>