<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Kantin') }}</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('favicon.jpg') }}?v=2">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">
    <div x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)"
        class="min-h-screen flex flex-col justify-center items-center p-6 relative overflow-hidden">
        {{-- Decorative background elements --}}
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-primary-200/50 rounded-full blur-3xl transition-all duration-1000 ease-out transform"
            :class="loaded ? 'translate-x-0 translate-y-0 opacity-100' : '-translate-x-10 -translate-y-10 opacity-0'">
        </div>
        <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-amber-200/50 rounded-full blur-3xl transition-all duration-1000 delay-300 ease-out transform"
            :class="loaded ? 'translate-x-0 translate-y-0 opacity-100' : 'translate-x-10 translate-y-10 opacity-0'">
        </div>

        <div class="relative z-10 w-full max-w-md flex flex-col items-center">
            {{-- Logo --}}
            <a href="/"
                class="mb-8 text-center flex flex-col items-center group transition-all duration-700 ease-out transform"
                :class="loaded ? 'translate-y-0 opacity-100' : '-translate-y-8 opacity-0'">
                <img src="{{ asset('favicon.jpg') }}" alt="Logo E-Kantin"
                    class="w-20 h-20 object-contain rounded-2xl shadow-md border border-gray-100 bg-white mb-4 group-hover:scale-105 group-hover:rotate-3 transition-transform duration-300">
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">E-<span
                        class="text-primary-500">Kantin</span></h1>
                <p class="text-sm text-gray-500 mt-1">SMKN 1 Purwokerto</p>
            </a>

            <div class="w-full bg-white rounded-2xl shadow-xl shadow-primary-500/5 border border-gray-100 p-8 transition-all duration-700 delay-150 ease-out transform"
                :class="loaded ? 'translate-y-0 opacity-100 scale-100' : 'translate-y-12 opacity-0 scale-95'">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>