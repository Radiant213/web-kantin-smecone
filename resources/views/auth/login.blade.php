<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Masuk ke Akun</h2>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">Pesan makanan favoritmu di kantin SMECONE tanpa antre.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Google OAuth Button -->
    <div class="mb-6">
        <a href="{{ route('auth.google') }}"
            class="w-full flex items-center justify-center gap-3 py-3 px-4 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-bold text-sm shadow-sm transition-all duration-200 active:scale-[0.98]">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
                <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.34 24 12 24z"/>
                <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z"/>
                <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.34 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
            </svg>
            Masuk dengan Google
        </a>
    </div>

    <!-- Divider -->
    <div class="relative flex items-center justify-center my-6">
        <div class="border-t border-slate-200 w-full"></div>
        <span class="bg-white px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400 absolute">
            atau dengan email
        </span>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                autocomplete="username"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20 text-sm font-medium text-slate-800 transition-colors placeholder:text-slate-400"
                placeholder="nama@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-primary-700 hover:text-primary-800 font-semibold"
                        href="{{ route('password.request') }}">
                        Lupa?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20 text-sm font-medium text-slate-800 transition-colors placeholder:text-slate-400"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="rounded border-slate-300 text-primary-700 shadow-sm focus:ring-primary-600" name="remember">
                <span class="ms-2 text-xs font-medium text-slate-600">Ingat saya</span>
            </label>
        </div>

        <button type="submit"
            class="w-full py-3.5 px-4 rounded-xl bg-primary-700 hover:bg-primary-800 active:bg-primary-900 text-white font-bold text-sm shadow-md shadow-primary-700/20 transition-all duration-200 active:scale-[0.99]">
            Masuk ke E-Kantin
        </button>

        <p class="text-center text-xs text-slate-500 pt-2">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-primary-700 hover:text-primary-800 font-bold">Daftar Akun Baru</a>
        </p>
    </form>
</x-guest-layout>
