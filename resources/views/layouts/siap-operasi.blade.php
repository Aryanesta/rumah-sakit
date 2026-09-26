<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SIAP OPERASI — {{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-rs-text-primary bg-rs-background">
        <div class="min-h-screen">
            <header class="bg-rs-primary-dark text-white px-4 py-5 sm:px-6">
                <div class="mx-auto max-w-3xl flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-white/70">Sistem Informasi dan Edukasi Persiapan Operasi</p>
                        <h1 class="text-2xl font-bold">SIAP OPERASI</h1>
                        <p class="text-sm text-white/80 mt-1">Lebih Siap, Lebih Paham, Lebih Aman.</p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-white/90 hover:text-white underline-offset-2 hover:underline">
                        Pemilih aplikasi
                    </a>
                </div>
            </header>

            @if ($breadcrumb)
                <div class="bg-rs-surface border-b border-rs-border px-4 py-2 text-xs text-rs-text-secondary sm:px-6">
                    <div class="mx-auto max-w-3xl">{{ $breadcrumb }}</div>
                </div>
            @endif

            <main class="px-4 py-6 sm:px-6 sm:py-8">
                <div class="mx-auto max-w-3xl">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
