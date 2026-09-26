<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-rs-text-primary">
        <div class="min-h-screen bg-white flex flex-col">
            <header class="flex items-center justify-end px-4 sm:px-8 py-3">
                <div class="flex items-center gap-2 sm:gap-4">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button type="button" class="flex items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-white/60 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-rs-primary/40">
                                <span class="flex h-9 w-9 items-center justify-center rounded-md bg-rs-primary text-sm font-bold text-white shadow-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="hidden sm:block text-left">
                                    <span class="block text-sm font-semibold text-rs-text-primary leading-tight">{{ Auth::user()->name }}</span>
                                    <span class="block text-xs text-rs-text-secondary">
                                        {{ Auth::user()->role instanceof \App\Enums\UserRole ? Auth::user()->role->label() : ucfirst((string) Auth::user()->role) }}
                                    </span>
                                </span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </header>

            <main class="flex-1 flex flex-col items-stretch px-4 sm:px-8 lg:px-12 pt-8 sm:pt-12 pb-16">
                <div class="max-w-6xl mx-auto w-full">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
