<x-guest-layout>
    <div class="bg-slate-900/80 backdrop-blur-xl border border-slate-800 rounded-2xl shadow-2xl p-8 sm:p-10 text-slate-100">
        <!-- Hospital Branding & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center p-3 bg-gradient-to-tr from-emerald-600 to-teal-500 rounded-2xl shadow-lg shadow-emerald-500/20 mb-4 ring-4 ring-emerald-500/10">
                <svg class="w-9 h-9 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2v20M2 12h20"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">Rumah Sakit Sehat</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Sistem Informasi Manajemen Rumah Sakit (SIMRS)</p>
            <div class="mt-2 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                Portal Akses Terpadu
            </div>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Quick Demo Autofill Badge for Superadmin -->
        <div class="mb-6 bg-slate-800/80 border border-slate-700/80 rounded-xl p-3.5">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2 text-xs text-slate-300">
                    <span class="text-base">🛡️</span>
                    <div>
                        <div class="font-semibold text-white">Akun Demo Superadmin</div>
                        <div class="text-slate-400 font-mono text-[11px]">superadmin &bull; password</div>
                    </div>
                </div>
                <button
                    type="button"
                    onclick="fillSuperAdmin()"
                    id="btn-quick-fill-superadmin"
                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-emerald-300 bg-emerald-950/80 hover:bg-emerald-900 border border-emerald-700/60 rounded-lg transition duration-150 active:scale-95 shadow-sm hover:text-white"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Isi Otomatis
                </button>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Username or Email Address -->
            <div>
                <label for="email" class="block text-xs font-medium text-slate-300 mb-1.5">
                    Username atau Email
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input
                        id="email"
                        class="block w-full pl-10 pr-4 py-2.5 bg-slate-800/60 border border-slate-700 rounded-xl text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                        type="text"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="superadmin atau nama@rumahsakit.com"
                    />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400 text-xs" />
            </div>

            <!-- Password -->
            <div x-data="{ show: false }">
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-medium text-slate-300">
                        Kata Sandi / Password
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-xs text-emerald-400 hover:text-emerald-300 transition" href="{{ route('password.request') }}">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input
                        id="password"
                        class="block w-full pl-10 pr-10 py-2.5 bg-slate-800/60 border border-slate-700 rounded-xl text-slate-100 placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                        :type="show ? 'text' : 'password'"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    <button
                        type="button"
                        @click="show = !show"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-200 transition"
                    >
                        <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="show" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-400 text-xs" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center select-none cursor-pointer">
                    <input
                        id="remember_me"
                        type="checkbox"
                        class="rounded border-slate-700 bg-slate-800 text-emerald-500 shadow-sm focus:ring-emerald-500/40 focus:ring-offset-slate-900"
                        name="remember"
                    >
                    <span class="ms-2 text-xs text-slate-300">Ingat sesi saya</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                id="btn-login-submit"
                class="w-full inline-flex justify-center items-center gap-2 py-3 px-4 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 hover:from-emerald-500 hover:via-teal-500 hover:to-cyan-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-slate-900 shadow-lg shadow-emerald-600/25 transition duration-150 ease-in-out active:scale-[0.99]"
            >
                <span>Masuk ke SIMRS</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-800 text-center text-xs text-slate-400">
            Rumah Sakit Management System &bull; Akses Terenkripsi
        </div>
    </div>

    <script>
        function fillSuperAdmin() {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            if (emailInput && passwordInput) {
                emailInput.value = 'superadmin';
                passwordInput.value = 'password';
                emailInput.classList.add('ring-2', 'ring-emerald-500');
                setTimeout(() => {
                    emailInput.classList.remove('ring-2', 'ring-emerald-500');
                }, 1000);
            }
        }
    </script>
</x-guest-layout>
