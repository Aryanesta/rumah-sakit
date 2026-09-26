<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rumah Sakit') }} - Ekosistem Digital Pelayanan Bedah &amp; Keperawatan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-rs-text-primary selection:bg-rs-primary selection:text-white min-h-screen">

    <header
        x-data="{ isScrolled: false }"
        x-init="isScrolled = window.pageYOffset > 48"
        @scroll.window.passive="isScrolled = window.pageYOffset > 48"
        class="fixed top-0 left-0 right-0 z-50 pointer-events-none transition-all duration-300 ease-out px-4 sm:px-6 lg:px-8"
    >
        <div class="max-w-7xl mx-auto w-full pointer-events-auto">
            <div
                class="transition-all duration-300 ease-out"
                :class="isScrolled
                    ? 'mt-3 sm:mt-4 rounded-2xl sm:rounded-full bg-white/75 backdrop-blur-xl border border-white/60 shadow-lg shadow-black/[0.06] py-2.5 sm:py-3 px-4 sm:px-6 lg:px-8'
                    : 'mt-0 rounded-none bg-transparent border border-transparent shadow-none py-4 sm:py-5 px-0'"
            >
                <div class="flex items-center justify-between gap-4">
                    <a href="{{ url('/') }}" class="group shrink-0 min-w-0">
                        <div class="min-w-0">
                            <span
                                class="font-black tracking-tight text-rs-text-primary block leading-tight transition-all duration-200"
                                :class="isScrolled ? 'text-base sm:text-lg' : 'text-lg sm:text-xl'"
                            >
                                RS Sehat Sejahtera
                            </span>
                            <span class="text-[10px] sm:text-[11px] font-bold text-rs-text-secondary tracking-wider uppercase block">
                                Ekosistem Medis Terpadu
                            </span>
                        </div>
                    </a>

                    <div class="flex items-center gap-4 sm:gap-6 shrink-0">
                        <nav
                            class="hidden md:flex items-center font-semibold text-rs-text-secondary transition-all duration-300"
                            :class="isScrolled ? 'gap-5 text-xs' : 'gap-6 text-sm'"
                        >
                            <a href="#tiga-pilar" class="hover:text-rs-primary transition-colors whitespace-nowrap">Modul Aplikasi</a>
                            <a href="{{ route('login') }}" class="hover:text-rs-primary transition-colors whitespace-nowrap">Portal Masuk</a>
                        </nav>

                        @auth
                            <a
                                href="{{ route('dashboard') }}"
                                class="inline-flex items-center gap-2 rounded-full font-bold text-white bg-rs-primary hover:bg-rs-primary-dark shadow-md shadow-rs-primary/15 transition-all duration-150 active:scale-95 whitespace-nowrap"
                                :class="isScrolled ? 'px-4 py-2 text-xs' : 'px-5 py-2.5 text-sm'"
                            >
                                <span class="hidden sm:inline">Buka Dashboard</span>
                                <span class="sm:hidden">Dashboard</span>
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="inline-flex items-center gap-2 rounded-full font-bold text-white bg-rs-primary hover:bg-rs-primary-dark shadow-md shadow-rs-primary/15 transition-all duration-150 active:scale-95 whitespace-nowrap"
                                :class="isScrolled ? 'px-4 py-2 text-xs' : 'px-5 py-2.5 text-sm'"
                            >
                                <span class="hidden sm:inline">Masuk ke Aplikasi</span>
                                <span class="sm:hidden">Masuk</span>
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section id="hero" class="relative min-h-screen flex items-center bg-white pt-24 sm:pt-28">
            <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pb-12 sm:pb-16">
                <div class="max-w-4xl flex flex-col gap-6 sm:gap-8">
                    <h1 class="flex flex-col gap-2 sm:gap-3 text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-rs-text-primary leading-[1.15] text-left">
                        <span class="whitespace-normal sm:whitespace-nowrap">Presisi, Keselamatan, &amp; Intelijen</span>
                        <span class="text-rs-text-secondary font-medium">dalam</span>
                        <span>
                            <span class="inline-block px-4 sm:px-6 py-0.5 sm:py-1 rounded-2xl bg-rs-primary text-white shadow-xl shadow-rs-primary/20 font-black align-baseline">
                                Satu Ekosistem Medis
                            </span>
                        </span>
                    </h1>

                    <div class="flex flex-wrap items-center gap-4">
                        @auth
                            <a
                                href="{{ route('dashboard') }}"
                                class="inline-flex items-center gap-2.5 px-7 py-3.5 sm:px-8 sm:py-4 rounded-full font-bold text-sm sm:text-base text-white bg-rs-primary hover:bg-rs-primary-dark shadow-xl shadow-rs-primary/20 transition-all duration-200 active:scale-95 group"
                            >
                                <span>Buka Dashboard</span>
                                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="inline-flex items-center gap-2.5 px-7 py-3.5 sm:px-8 sm:py-4 rounded-full font-bold text-sm sm:text-base text-white bg-rs-primary hover:bg-rs-primary-dark shadow-xl shadow-rs-primary/20 transition-all duration-200 active:scale-95 group"
                            >
                                <span>Masuk ke Aplikasi</span>
                                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        <!-- Three Main Applications Section (Interactive Cards with Slanted Overlay & Indefinite Shaky Logo) -->
        <section id="tiga-pilar" class="py-20 bg-[#E5E5E5] border-y border-[#D4D4D4]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto mb-14">
                    <h2 class="text-3xl sm:text-5xl font-black text-rs-text-primary tracking-tight">
                        Satu Ekosistem, Tiga Pilar Perlindungan
                    </h2>
                </div>

                <!-- 3-Column Responsive Module Cards Grid (Based on Reference) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 max-w-6xl mx-auto w-full">
                    
                    <!-- Card 1: Surgicon -->
                    <a href="{{ route('login') }}" class="group relative block h-88 sm:h-96 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300">
                        <div
                            class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                            style="background-image: url('{{ asset('images/landing/surgicon.jpg') }}');"
                            role="presentation"
                        ></div>
                        <div class="absolute inset-0 bg-slate-950/55 group-hover:bg-slate-950/45 transition-colors duration-300" aria-hidden="true"></div>
                        <!-- Top-Right Cropped Large Module Logo (Shakes Indefinitely on Hover) -->
                        <div class="absolute -top-6 -right-6 w-36 h-36 sm:w-44 sm:h-44 pointer-events-none select-none transition-transform duration-500 group-hover:scale-105 group-hover:animate-shake z-10">
                            <svg class="w-full h-full text-emerald-500/75 drop-shadow-[0_0_20px_rgba(16,185,129,0.35)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2L3 7v9c0 5 9 8 9 8s9-3 9-8V7l-9-5z"/>
                                <path d="M12 8v8M8 12h8"/>
                            </svg>
                        </div>

                        <!-- Unhovered Bottom Bar: Title & Accent Line (Hidden when hovered) -->
                        <div class="absolute inset-x-0 bottom-0 z-10 p-6 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent transition-opacity duration-300 group-hover:opacity-0 pointer-events-none">
                            <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight">Surgicon</h3>
                            <div class="mt-3 h-1.5 w-full bg-emerald-500 rounded-full"></div>
                        </div>

                        <!-- Hovered Slanted/Angled Color Overlay (Smoothly slides up from bottom) -->
                        <div 
                            class="absolute inset-x-0 bottom-0 z-20 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out bg-emerald-600/95 backdrop-blur-sm text-white p-6 pt-11 sm:p-7 sm:pt-12 flex flex-col justify-between"
                            style="clip-path: polygon(0 12%, 100% 0, 100% 100%, 0 100%);"
                        >
                            <div>
                                <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight mb-2">Surgicon</h3>
                                <p class="text-xs sm:text-sm text-emerald-50 leading-relaxed font-normal">
                                    Pencatatan alur operasi bedah, verifikasi checklist keselamatan Pre-OP dan Post-OP, serta pemantauan kesiapan kamar operasi.
                                </p>
                            </div>
                            <div class="mt-4 pt-2 flex items-center gap-2 text-xs sm:text-sm font-bold text-white">
                                <span>Buka Modul</span>
                                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                        </div>
                    </a>

                    <!-- Card 2: Angsmart -->
                    <a href="{{ route('login') }}" class="group relative block h-88 sm:h-96 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300">
                        <div
                            class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                            style="background-image: url('{{ asset('images/landing/angsmart.jpg') }}');"
                            role="presentation"
                        ></div>
                        <div class="absolute inset-0 bg-slate-950/55 group-hover:bg-slate-950/45 transition-colors duration-300" aria-hidden="true"></div>
                        <!-- Top-Right Cropped Large Module Logo (Shakes Indefinitely on Hover) -->
                        <div class="absolute -top-6 -right-6 w-36 h-36 sm:w-44 sm:h-44 pointer-events-none select-none transition-transform duration-500 group-hover:scale-105 group-hover:animate-shake z-10">
                            <svg class="w-full h-full text-blue-500/75 drop-shadow-[0_0_20px_rgba(59,130,246,0.35)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12h4l3 8 4-16 3 8h4"/>
                            </svg>
                        </div>

                        <!-- Unhovered Bottom Bar: Title & Accent Line (Hidden when hovered) -->
                        <div class="absolute inset-x-0 bottom-0 z-10 p-6 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent transition-opacity duration-300 group-hover:opacity-0 pointer-events-none">
                            <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight">Angsmart</h3>
                            <div class="mt-3 h-1.5 w-full bg-blue-500 rounded-full"></div>
                        </div>

                        <!-- Hovered Slanted/Angled Color Overlay (Smoothly slides up from bottom) -->
                        <div 
                            class="absolute inset-x-0 bottom-0 z-20 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out bg-blue-600/95 backdrop-blur-sm text-white p-6 pt-11 sm:p-7 sm:pt-12 flex flex-col justify-between"
                            style="clip-path: polygon(0 12%, 100% 0, 100% 100%, 0 100%);"
                        >
                            <div>
                                <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight mb-2">Angsmart</h3>
                                <p class="text-xs sm:text-sm text-blue-50 leading-relaxed font-normal">
                                    Dokumentasi asuhan keperawatan harian dan pencatatan operan jaga (handover) antar shift perawat rawat inap.
                                </p>
                            </div>
                            <div class="mt-4 pt-2 flex items-center gap-2 text-xs sm:text-sm font-bold text-white">
                                <span>Buka Modul</span>
                                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                        </div>
                    </a>

                    <!-- Card 3: ANSafe -->
                    <a href="{{ route('login') }}" class="group relative block h-88 sm:h-96 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300">
                        <div
                            class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                            style="background-image: url('{{ asset('images/landing/ansafe.jpg') }}');"
                            role="presentation"
                        ></div>
                        <div class="absolute inset-0 bg-slate-950/55 group-hover:bg-slate-950/45 transition-colors duration-300" aria-hidden="true"></div>
                        <!-- Top-Right Cropped Large Module Logo (Shakes Indefinitely on Hover) -->
                        <div class="absolute -top-6 -right-6 w-36 h-36 sm:w-44 sm:h-44 pointer-events-none select-none transition-transform duration-500 group-hover:scale-105 group-hover:animate-shake z-10">
                            <svg class="w-full h-full text-amber-500/75 drop-shadow-[0_0_20px_rgba(245,158,11,0.35)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                <path d="M9 12l2 2 4-4"/>
                            </svg>
                        </div>

                        <!-- Unhovered Bottom Bar: Title & Accent Line (Hidden when hovered) -->
                        <div class="absolute inset-x-0 bottom-0 z-10 p-6 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent transition-opacity duration-300 group-hover:opacity-0 pointer-events-none">
                            <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight">ANSafe</h3>
                            <div class="mt-3 h-1.5 w-full bg-amber-500 rounded-full"></div>
                        </div>

                        <!-- Hovered Slanted/Angled Color Overlay (Smoothly slides up from bottom) -->
                        <div 
                            class="absolute inset-x-0 bottom-0 z-20 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out bg-amber-600/95 backdrop-blur-sm text-white p-6 pt-11 sm:p-7 sm:pt-12 flex flex-col justify-between"
                            style="clip-path: polygon(0 12%, 100% 0, 100% 100%, 0 100%);"
                        >
                            <div>
                                <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight mb-2">ANSafe</h3>
                                <p class="text-xs sm:text-sm text-amber-50 leading-relaxed font-normal">
                                    Pengkajian risiko jatuh pasien menggunakan indikator Morse Fall Scale serta materi edukasi keselamatan pasien.
                                </p>
                            </div>
                            <div class="mt-4 pt-2 flex items-center gap-2 text-xs sm:text-sm font-bold text-white">
                                <span>Buka Modul</span>
                                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                        </div>
                    </a>

                </div>

            </div>
        </section>

    </main>

    <!-- Laravel-Style Massive Wordmark Footer -->
    <footer class="border-t border-slate-800 bg-black pt-16 pb-0 overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Footer Links Row -->
            <div class="flex flex-wrap items-center justify-between gap-6 pb-12 border-b border-slate-800 text-xs sm:text-sm font-semibold text-slate-400">
                <div class="flex items-center gap-6">
                    <a href="#tiga-pilar" class="hover:text-white transition-colors">Surgicon</a>
                    <a href="#tiga-pilar" class="hover:text-white transition-colors">Angsmart</a>
                    <a href="#tiga-pilar" class="hover:text-white transition-colors">ANSafe</a>
                </div>
                <div class="flex items-center gap-6">
                    <a href="{{ route('login') }}" class="hover:text-white font-bold transition-colors">Masuk ke Aplikasi &rarr;</a>
                    <span>&copy; {{ date('Y') }} RS Sehat Sejahtera. Hak Cipta Dilindungi Undang-Undang.</span>
                </div>
            </div>
        </div>

        <!-- Colossal Brand Wordmark (Exact Laravel-style as shown in reference) -->
        <div class="w-full overflow-hidden select-none pointer-events-none text-center pt-8 sm:pt-12">
            <span class="block text-[11vw] sm:text-[13vw] font-black tracking-tighter leading-none text-neutral-800 whitespace-nowrap">
                RS Sehat Sejahtera
            </span>
        </div>
    </footer>

</body>
</html>
