<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body
        @if ($pastel) data-guest-theme="pastel" @endif
        @class([
            'font-sans antialiased min-h-screen relative overflow-x-hidden',
            'bg-rs-background text-rs-text-primary selection:bg-rs-primary selection:text-white' => $pastel,
            'text-gray-900 bg-slate-950 selection:bg-emerald-500 selection:text-white' => ! $pastel,
        ])
    >
        <!-- Ambient Background -->
        <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
            @if ($pastel)
                <div class="absolute -top-32 -left-32 w-80 h-80 bg-rs-primary/15 rounded-full blur-3xl"></div>
                <div class="absolute top-1/4 -right-32 w-96 h-96 bg-rs-accent/20 rounded-full blur-3xl"></div>
            @else
                <div class="absolute -top-40 -left-40 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl"></div>
                <div class="absolute top-1/3 -right-40 w-96 h-96 bg-teal-500/15 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-40 left-1/3 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl"></div>
                <div class="absolute inset-0 bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:24px_24px] opacity-40"></div>
            @endif
        </div>

        @if ($wide)
            <div @class([
                'relative z-10 w-full flex flex-col',
                'min-h-[100dvh] items-center justify-center px-4 py-8' => $pastel,
                'min-h-[100dvh] justify-center items-center py-6 sm:py-8 px-4 sm:px-6 lg:px-10' => ! $pastel,
            ])>
                @if ($pastel)
                    {{ $slot }}
                @else
                    <div class="w-full max-w-6xl">
                        {{ $slot }}
                    </div>
                @endif
            </div>
        @else
            <div class="min-h-screen flex flex-col justify-center items-center py-10 px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>
        @endif
    </body>
</html>
