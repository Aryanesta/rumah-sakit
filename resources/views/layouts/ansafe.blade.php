<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>ANSafe — {{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-rs-text-primary bg-rs-background">
        <div class="min-h-screen flex">
            <x-ansafe.sidebar />

            <div class="flex-1 flex flex-col min-w-0">
                <header class="bg-rs-surface border-b border-rs-border px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            @if ($breadcrumb)
                                <p class="text-xs text-rs-text-secondary mb-1">{{ $breadcrumb }}</p>
                            @endif
                            <p class="text-sm text-rs-text-secondary">
                                Selamat datang, <span class="font-semibold text-rs-text-primary">{{ Auth::user()->name }}</span>
                                <span class="hidden sm:inline"> · Shift 07:00–15:00</span>
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-rs-primary hover:text-rs-primary-dark transition-colors">
                                Pemilih aplikasi
                            </a>
                            <button type="button" class="relative rounded-lg p-2 text-rs-text-secondary hover:bg-rs-background transition" aria-label="Notifikasi">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <span class="absolute top-1.5 right-1.5 h-2 w-2 rounded-full bg-rs-emergency"></span>
                            </button>
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-rs-primary text-sm font-bold text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>
                    </div>
                </header>

                <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-x-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
