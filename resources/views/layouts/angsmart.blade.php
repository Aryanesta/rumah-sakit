<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Angsmart — {{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-rs-text-primary bg-rs-background" x-data="{ sidebarOpen: false }">
        <div class="min-h-screen flex">
            <div
                class="fixed inset-0 z-40 bg-black/40 lg:hidden"
                x-show="sidebarOpen"
                x-transition.opacity
                @click="sidebarOpen = false"
                x-cloak
            ></div>

            <div
                class="fixed inset-y-0 left-0 z-50 lg:static lg:z-auto transform transition-transform duration-200 lg:translate-x-0"
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            >
                <x-angsmart.sidebar />
            </div>

            <div class="flex-1 flex flex-col min-w-0">
                <header class="bg-rs-surface border-b border-rs-border px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-start gap-3">
                            <button
                                type="button"
                                class="lg:hidden rounded-lg p-2 text-rs-text-secondary hover:bg-rs-background"
                                @click="sidebarOpen = true"
                                aria-label="Buka menu"
                            >
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                            <div>
                                @if ($breadcrumb)
                                    <p class="text-xs text-rs-text-secondary mb-1">{{ $breadcrumb }}</p>
                                @endif
                                <p class="text-sm text-rs-text-secondary">
                                    Selamat datang, <span class="font-semibold text-rs-text-primary">{{ Auth::user()->name }}</span>
                                </p>
                                <p class="text-xs text-rs-text-secondary mt-0.5">
                                    Perawat | Shift Pagi (07.00 – 14.00)
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 sm:justify-end">
                            <span class="text-sm text-rs-text-secondary hidden sm:inline">
                                {{ now()->translatedFormat('d F Y') }}
                            </span>
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-rs-primary hover:text-rs-primary-dark transition-colors">
                                Pemilih aplikasi
                            </a>
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-rs-primary text-sm font-bold text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>
                    </div>
                </header>

                <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-x-auto">
                    @if (session('status') === 'demo-patient-saved')
                        <div class="mb-4 rounded-xl border border-rs-success/40 bg-rs-success/15 px-4 py-3 text-sm text-rs-text-primary" role="status">
                            Data pasien tersimpan (mode demo — belum disimpan ke database).
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
