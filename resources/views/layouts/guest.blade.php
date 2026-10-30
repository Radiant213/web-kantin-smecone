<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SMECONE E-Kantin') }} - SMK Negeri 1 Purwokerto</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-smecone.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between">
    {{-- Header / Top subtle bar --}}
    <div class="h-1.5 bg-gradient-to-r from-primary-700 via-amber-400 to-primary-800"></div>

    <div class="flex-1 flex flex-col justify-center items-center px-4 py-12 relative overflow-hidden">
        {{-- Subtle background glow --}}
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-primary-100/60 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-amber-100/50 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 w-full max-w-md">
            {{-- Institutional School Logo & Title --}}
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex flex-col items-center group">
                    <div class="w-20 h-20 rounded-2xl bg-white p-2 shadow-md border border-slate-200/80 group-hover:scale-105 transition-transform duration-300 flex items-center justify-center">
                        <img src="{{ asset('images/logo-smecone.png') }}" alt="Logo SMECONE" class="w-full h-full object-contain">
                    </div>
                    <div class="mt-3">
                        <span class="text-xs font-bold tracking-widest uppercase text-primary-700 bg-primary-50 px-2.5 py-0.5 rounded-full border border-primary-200">
                            SMK Negeri 1 Purwokerto
                        </span>
                        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">
                            SMECONE <span class="text-primary-700">E-Kantin</span>
                        </h1>
                    </div>
                </a>
            </div>

            {{-- Auth Card --}}
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200/80 p-8 sm:p-10">
                {{ $slot }}
            </div>

            {{-- Footer info --}}
            <div class="text-center mt-6 text-xs text-slate-400">
                <p>&copy; {{ date('Y') }} SMECONE E-Kantin. Layanan Pesan Makanan Bebas Antre.</p>
            </div>
        </div>
    </div>

    <div></div>
</body>

</html>
