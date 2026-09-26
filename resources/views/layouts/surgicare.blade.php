<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Surgicare — {{ config('app.name') }}</title>

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
                <x-surgicare.sidebar />
            </div>

            <div class="flex-1 flex flex-col min-w-0">
                <header class="bg-rs-surface border-b border-rs-border px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-3">
                            <button
                                type="button"
                                class="rounded-lg p-2 text-rs-text-secondary hover:bg-rs-background"
                                @click="sidebarOpen = true"
                                aria-label="Buka menu"
                            >
                                <svg class="h-6 w-6 lg:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                            @if ($breadcrumb)
                                <p class="text-xs text-rs-text-secondary hidden sm:block">{{ $breadcrumb }}</p>
                            @endif
                        </div>

                        <div class="flex items-center gap-3 sm:justify-end">
                            <button type="button" class="relative rounded-lg p-2 text-rs-text-secondary hover:bg-rs-background transition" aria-label="Notifikasi">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </button>
                            <div class="flex items-center gap-2">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-rs-primary-light/50 text-rs-primary-dark text-sm font-bold">
                                    MS
                                </span>
                                <div class="hidden sm:block text-left">
                                    <p class="text-sm font-semibold text-rs-text-primary">{{ \App\Support\Surgicare\SurgicareDemoData::DEMO_NURSE_NAME }}</p>
                                    <p class="text-xs text-rs-text-secondary">{{ \App\Support\Surgicare\SurgicareDemoData::DEMO_NURSE_ROLE }}</p>
                                </div>
                                <svg class="h-4 w-4 text-rs-text-secondary hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-rs-primary hover:text-rs-primary-dark transition-colors ml-2">
                                Pemilih aplikasi
                            </a>
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
