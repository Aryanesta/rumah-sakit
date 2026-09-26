<x-guest-layout :wide="true" :pastel="true">
    <div
        x-data="{ showPassword: false }"
        class="animate-page-enter w-full max-w-6xl flex flex-col lg:flex-row bg-rs-surface rounded-3xl shadow-lg shadow-rs-text-primary/5 border border-rs-border/60 overflow-hidden lg:min-h-[640px]"
    >
        <!-- Left: form -->
        <section class="lg:w-1/2 flex items-center justify-center p-8 sm:p-10 lg:p-12">
            <div class="w-full max-w-md flex flex-col gap-6">
                <div class="space-y-2">
                    <h1 class="text-3xl sm:text-4xl font-semibold text-rs-text-primary tracking-tight">
                        Selamat datang
                    </h1>
                    <p class="text-sm text-rs-text-secondary leading-relaxed">
                        Masuk ke akun SIMRS <span class="font-medium text-rs-text-primary">Rumah Sakit Sehat</span>.
                    </p>
                </div>

                <x-auth-session-status class="mb-0" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div class="space-y-1.5">
                        <label for="email" class="block text-sm font-medium text-rs-text-secondary">
                            Username atau Email
                        </label>
                        <input
                            id="email"
                            type="text"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="Masukkan username atau email"
                            class="w-full rounded-2xl border-0 bg-rs-background px-4 py-3.5 text-sm text-rs-text-primary placeholder:text-rs-text-secondary/60 focus:outline-none focus:ring-2 focus:ring-rs-primary/35"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-rs-emergency text-xs" />
                    </div>

                    <div class="space-y-1.5">
                        <label for="password" class="block text-sm font-medium text-rs-text-secondary">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan kata sandi"
                                class="w-full rounded-2xl border-0 bg-rs-background px-4 py-3.5 pr-12 text-sm text-rs-text-primary placeholder:text-rs-text-secondary/60 focus:outline-none focus:ring-2 focus:ring-rs-primary/35"
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-rs-text-secondary hover:text-rs-text-primary transition"
                                aria-label="Toggle password visibility"
                            >
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-rs-emergency text-xs" />
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label for="remember" class="inline-flex items-center gap-2.5 select-none cursor-pointer">
                            <input
                                id="remember"
                                type="checkbox"
                                name="remember"
                                class="rounded border-rs-border text-rs-primary shadow-sm focus:ring-rs-primary/40 focus:ring-offset-rs-surface"
                            />
                            <span class="text-rs-text-primary">Ingat sesi saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="font-medium text-rs-primary hover:text-rs-primary-dark transition">
                                Lupa kata sandi?
                            </a>
                        @endif
                    </div>

                    <button
                        type="submit"
                        id="btn-login-submit"
                        class="w-full rounded-2xl bg-rs-text-primary py-3.5 text-sm font-semibold text-white hover:bg-black focus:outline-none focus:ring-2 focus:ring-rs-text-primary focus:ring-offset-2 focus:ring-offset-rs-surface transition active:scale-[0.99]"
                    >
                        Masuk ke SIMRS
                    </button>
                </form>

                <p class="text-center text-sm text-rs-text-secondary">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium text-rs-primary hover:text-rs-primary-dark hover:underline transition">
                        Daftar akun baru
                    </a>
                </p>
            </div>
        </section>

        <!-- Right: hero -->
        <section class="hidden lg:flex lg:w-1/2 p-4">
            <div class="relative flex-1 rounded-3xl overflow-hidden min-h-[320px]">
                <div
                    class="absolute inset-0 bg-cover bg-center"
                    style="background-image: url('https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1200&q=80');"
                ></div>
                <div class="absolute inset-0 bg-gradient-to-br from-rs-primary/70 via-rs-primary-dark/50 to-rs-accent/60"></div>
            </div>
        </section>
    </div>
</x-guest-layout>
