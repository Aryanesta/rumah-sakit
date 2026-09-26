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
    <body
        class="font-sans antialiased text-rs-text-primary bg-white"
        x-data="{
            sidebarOpen: false,
            headerScrolled: false,
            updateHeaderScrolled() {
                this.headerScrolled = window.scrollY > 12;
            },
        }"
        x-init="updateHeaderScrolled()"
        @scroll.window="updateHeaderScrolled()"
    >
        <div class="min-h-screen">
            <div
                class="fixed inset-0 z-40 bg-black/40 lg:hidden"
                x-show="sidebarOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="sidebarOpen = false"
                x-cloak
            ></div>

            <div
                class="fixed inset-y-0 left-0 z-50 w-[calc(16rem+1rem)] max-w-[90vw] p-2 transform transition-transform duration-300 ease-out lg:translate-x-0"
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            >
                <x-ansafe.sidebar />
            </div>

            <div class="flex flex-col min-w-0 min-h-screen lg:pl-[calc(16rem+1rem)]">
                <div class="flex flex-1 flex-col bg-white min-h-screen animate-page-enter">
                    <header
                        class="sticky top-0 z-30 bg-white px-4 sm:px-6 lg:px-8 py-4 sm:py-5 animate-element border-b border-transparent transition-[background-color,backdrop-filter,border-color,box-shadow] duration-200 ease-out"
                        :class="headerScrolled ? 'bg-white/95 backdrop-blur-sm border-rs-border/50 shadow-sm' : ''"
                    >
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-3 min-w-0">
                                <button
                                    type="button"
                                    class="lg:hidden shrink-0 rounded-lg p-2 text-rs-text-secondary hover:bg-rs-background transition-colors duration-200"
                                    @click="sidebarOpen = true"
                                    aria-label="Buka menu"
                                >
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                                    </svg>
                                </button>
                                @if ($pageTitle)
                                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-amber-600 truncate">
                                        {{ $pageTitle }}
                                    </h1>
                                @endif
                            </div>

                            <div class="flex items-center gap-3 sm:justify-end shrink-0">
                                <div class="text-sm text-rs-text-secondary text-left sm:text-right">
                                    <p>
                                        Selamat datang, <span class="font-semibold text-rs-text-primary">{{ Auth::user()->name }}</span>
                                    </p>
                                    <p class="mt-0.5 text-xs sm:text-sm">Shift 07:00–15:00</p>
                                </div>
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-amber-600 text-sm font-bold text-white">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            </div>
                        </div>
                    </header>

                    <main class="flex-1 px-4 sm:px-6 lg:px-8 pt-6 sm:pt-8 pb-4 sm:pb-6 lg:pb-8 overflow-x-auto animate-element animate-delay-100">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
