<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Dashboard SIMRS') }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Sistem Informasi Manajemen Rumah Sakit</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sistem Beroperasi Normal
                </span>
                <span class="text-xs text-slate-400 font-mono hidden md:inline-block">{{ now()->format('d M Y, H:i') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Login Greeting Toast / Banner -->
            @if (session('login_greeting'))
                <div x-data="{ show: true }" x-show="show" x-transition class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-2xl p-4 shadow-lg shadow-emerald-500/10 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/20 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-sm sm:text-base">{{ session('login_greeting') }}</div>
                            <div class="text-xs text-emerald-100">Sesi otentikasi Anda telah aktif dan terverifikasi secara aman.</div>
                        </div>
                    </div>
                    <button @click="show = false" class="text-white/80 hover:text-white p-1.5 rounded-lg hover:bg-white/10 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Main Personalized Role Greeting Card -->
            <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-teal-950 text-white rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-700/60">
                <!-- Background Glow -->
                <div class="absolute -right-16 -top-16 w-80 h-80 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -left-16 -bottom-16 w-80 h-80 bg-teal-500/15 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="space-y-3 max-w-2xl">
                        <!-- Role Badge -->
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase shadow-sm border {{ Auth::user()->role instanceof \App\Enums\UserRole ? Auth::user()->role->badgeClasses() : 'bg-purple-100 text-purple-800 border-purple-200' }}">
                            <span class="text-sm">{{ Auth::user()->role instanceof \App\Enums\UserRole ? Auth::user()->role->icon() : '🛡️' }}</span>
                            <span>Peran Akun: {{ Auth::user()->role instanceof \App\Enums\UserRole ? Auth::user()->role->label() : ucfirst((string) Auth::user()->role) }}</span>
                        </div>

                        <!-- Warm Greeting -->
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight">
                            Selamat Datang, <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-300">{{ Auth::user()->name }}</span>! 👋
                        </h1>

                        <!-- Detailed Role Greeting Subtitle -->
                        <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                            Anda berhasil masuk ke portal Rumah Sakit dengan peran
                            <span class="font-semibold text-emerald-300 underline decoration-emerald-500/40 underline-offset-4">
                                {{ Auth::user()->role instanceof \App\Enums\UserRole ? Auth::user()->role->label() : ucfirst((string) Auth::user()->role) }}
                            </span>.
                            @if(Auth::user()->isSuperAdmin())
                                Anda memiliki otoritas dan hak akses penuh atas seluruh modul operasional, manajemen staf medis, rekam medis pasien, serta konfigurasi sistem.
                            @else
                                Selamat menjalankan tugas medis dan pelayanan pasien hari ini dengan dedikasi terbaik.
                            @endif
                        </p>
                    </div>

                    <!-- Quick User Profile Snippet Card -->
                    <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-4 sm:p-5 flex items-center gap-4 shrink-0">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white text-xl font-bold shadow-md shadow-emerald-500/20">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-xs text-slate-400">Pengguna Terverifikasi</div>
                            <div class="font-bold text-white text-sm sm:text-base">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-emerald-400 font-mono">{{ Auth::user()->email }}</div>
                            @if(Auth::user()->username)
                                <div class="text-[11px] text-slate-400 font-mono">@<span>{{ Auth::user()->username }}</span></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hospital Quick Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Stat 1: Doctors -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Dokter Bertugas</p>
                            <h3 class="text-2xl font-bold text-slate-800 mt-1">48 <span class="text-xs font-normal text-slate-500">Spesialis</span></h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                            🩺
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-emerald-600 font-medium">
                        <span>↑ 4 dokter on-call</span>
                        <span class="text-slate-400 ml-2">Jadwal Shift Pagi & Malam</span>
                    </div>
                </div>

                <!-- Stat 2: Bed Occupancy -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Kapasitas Tempat Tidur</p>
                            <h3 class="text-2xl font-bold text-slate-800 mt-1">234 <span class="text-xs font-normal text-slate-500">/ 280</span></h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl">
                            🛏️
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-teal-600 font-medium">
                        <span>83.5% Okupansi</span>
                        <span class="text-slate-400 ml-2">46 Ranjang Tersedia</span>
                    </div>
                </div>

                <!-- Stat 3: Patients Today -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Pasien Hari Ini</p>
                            <h3 class="text-2xl font-bold text-slate-800 mt-1">1,420 <span class="text-xs font-normal text-slate-500">Orang</span></h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                            👥
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-blue-600 font-medium">
                        <span>Rawat Jalan & Inap</span>
                        <span class="text-slate-400 ml-2">Terdaftar di SIMRS</span>
                    </div>
                </div>

                <!-- Stat 4: IGD / Emergency -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Unit IGD (24 Jam)</p>
                            <h3 class="text-2xl font-bold text-slate-800 mt-1">12 <span class="text-xs font-normal text-slate-500">Kasus Aktif</span></h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                            🚑
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-rose-600 font-medium">
                        <span>Status: Siaga Cepat</span>
                        <span class="text-slate-400 ml-2">3 Ambulans Siap</span>
                    </div>
                </div>
            </div>

            <!-- Quick Action Hub for Superadmin -->
            @if(Auth::user()->isSuperAdmin())
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                <span>⚡</span> Modul Akses Cepat Superadmin
                            </h3>
                            <p class="text-xs text-slate-500">Akses kontrol langsung untuk administrasi rumah sakit terpadu</p>
                        </div>
                        <span class="text-xs font-semibold px-2.5 py-1 bg-purple-50 text-purple-700 rounded-lg border border-purple-200">
                            Akses Penuh
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-2">
                        <div class="group p-4 rounded-xl border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/30 transition cursor-pointer">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg mb-3 group-hover:scale-105 transition">
                                👥
                            </div>
                            <h4 class="font-semibold text-sm text-slate-800 group-hover:text-emerald-700">Manajemen Pengguna</h4>
                            <p class="text-xs text-slate-500 mt-1">Kelola akun dokter, perawat, apoteker, dan hak akses.</p>
                        </div>

                        <div class="group p-4 rounded-xl border border-slate-200 hover:border-teal-300 hover:bg-teal-50/30 transition cursor-pointer">
                            <div class="w-10 h-10 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-lg mb-3 group-hover:scale-105 transition">
                                🏥
                            </div>
                            <h4 class="font-semibold text-sm text-slate-800 group-hover:text-teal-700">Bangsal & Kamar</h4>
                            <p class="text-xs text-slate-500 mt-1">Atur alokasi tempat tidur ICU, VIP, dan kelas perawatan.</p>
                        </div>

                        <div class="group p-4 rounded-xl border border-slate-200 hover:border-blue-300 hover:bg-blue-50/30 transition cursor-pointer">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-lg mb-3 group-hover:scale-105 transition">
                                📋
                            </div>
                            <h4 class="font-semibold text-sm text-slate-800 group-hover:text-blue-700">Rekam Medis (EMR)</h4>
                            <p class="text-xs text-slate-500 mt-1">Pantau integritas arsip riwayat medis dan diagnosa pasien.</p>
                        </div>

                        <div class="group p-4 rounded-xl border border-slate-200 hover:border-amber-300 hover:bg-amber-50/30 transition cursor-pointer">
                            <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-lg mb-3 group-hover:scale-105 transition">
                                ⚙️
                            </div>
                            <h4 class="font-semibold text-sm text-slate-800 group-hover:text-amber-700">Audit & Konfigurasi</h4>
                            <p class="text-xs text-slate-500 mt-1">Audit log keamanan, backup basis data, dan konfigurasi API.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Hospital Operations Status Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- System Audit & Status -->
                <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm">
                    <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span>📡</span> Log Aktivitas & Sistem Terkini
                    </h3>
                    <div class="space-y-3.5">
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5 shrink-0"></div>
                            <div class="flex-1 text-xs">
                                <div class="font-semibold text-slate-800">Sesi Login Berhasil</div>
                                <div class="text-slate-500">Pengguna <strong>{{ Auth::user()->name }}</strong> masuk sebagai <strong>{{ Auth::user()->role instanceof \App\Enums\UserRole ? Auth::user()->role->label() : Auth::user()->role }}</strong> dari IP {{ request()->ip() }}.</div>
                            </div>
                            <span class="text-[11px] text-slate-400 font-mono">Baru saja</span>
                        </div>
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="w-2 h-2 rounded-full bg-blue-500 mt-1.5 shrink-0"></div>
                            <div class="flex-1 text-xs">
                                <div class="font-semibold text-slate-800">Sinkronisasi Database Rumah Sakit</div>
                                <div class="text-slate-500">Backup otomatis modul farmasi dan rawat inap selesai tanpa kendala.</div>
                            </div>
                            <span class="text-[11px] text-slate-400 font-mono">15m lalu</span>
                        </div>
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="w-2 h-2 rounded-full bg-teal-500 mt-1.5 shrink-0"></div>
                            <div class="flex-1 text-xs">
                                <div class="font-semibold text-slate-800">Pembaruan Jadwal Dokter Jaga</div>
                                <div class="text-slate-500">Jadwal poliklinik spesialis penyakit dalam dan poli anak telah diperbarui.</div>
                            </div>
                            <span class="text-[11px] text-slate-400 font-mono">1j lalu</span>
                        </div>
                    </div>
                </div>

                <!-- Hospital Facility Info -->
                <div class="bg-gradient-to-br from-teal-500 to-emerald-600 rounded-2xl p-6 text-white shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white backdrop-blur-sm mb-4">
                            🏥 RS Sehat Sejahtera
                        </div>
                        <h4 class="text-xl font-bold">Layanan Kesehatan Paripurna</h4>
                        <p class="text-xs text-teal-100 mt-2 leading-relaxed">
                            Terakreditasi Paripurna KARS. Siap melayani pasien 24 jam dengan fasilitas medis mutakhir dan standar pelayanan terbaik.
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-white/20 flex items-center justify-between text-xs">
                        <div>
                            <div class="text-teal-200 text-[11px]">Emergency Hotline</div>
                            <div class="font-bold text-white text-sm">119 / (021) 555-0123</div>
                        </div>
                        <span class="px-2.5 py-1 bg-white text-teal-800 rounded-lg font-bold text-xs shadow-sm">
                            24 Jam
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
