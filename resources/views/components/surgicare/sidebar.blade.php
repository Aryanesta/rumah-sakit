@php
    use App\Support\Surgicare\SurgicareDemoData;
@endphp

<aside class="flex w-64 h-full min-h-screen flex-col bg-rs-primary-dark text-white shrink-0">
    <div class="px-5 py-6 border-b border-white/10">
        <a href="{{ route('apps.surgicare.index') }}" class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/15">
                <x-icons.surgicare class="h-6 w-6 text-white" />
            </span>
            <p class="font-bold text-lg leading-tight tracking-wide">SURGICARE</p>
        </a>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-1" aria-label="Navigasi Surgicare">
        <x-surgicare.sidebar-nav-item
            :href="route('apps.surgicare.index')"
            :active="request()->routeIs('apps.surgicare.index')"
            label="Beranda"
        >
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </x-slot:icon>
        </x-surgicare.sidebar-nav-item>

        <x-surgicare.sidebar-nav-item
            :href="route('apps.surgicare.monitoring.index')"
            :active="request()->routeIs('apps.surgicare.monitoring.*')"
            label="Monitoring Akun Pasien"
        >
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </x-slot:icon>
        </x-surgicare.sidebar-nav-item>

        <x-surgicare.sidebar-nav-item
            :href="route('apps.surgicare.patients.index')"
            :active="request()->routeIs('apps.surgicare.patients.index')"
            label="Patient List"
        >
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </x-slot:icon>
        </x-surgicare.sidebar-nav-item>

        <x-surgicare.sidebar-nav-item
            :href="route('apps.surgicare.patients.pre-op-checklist', SurgicareDemoData::DEFAULT_PRE_OP_SLUG)"
            :active="request()->routeIs('apps.surgicare.patients.pre-op-checklist')"
            label="Pre-Op Checklist"
        >
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </x-slot:icon>
        </x-surgicare.sidebar-nav-item>

        <x-surgicare.sidebar-nav-item
            :href="route('apps.surgicare.patients.post-op-checklist', SurgicareDemoData::DEFAULT_POST_OP_SLUG)"
            :active="request()->routeIs('apps.surgicare.patients.post-op-checklist')"
            label="Post-Op Checklist"
        >
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </x-slot:icon>
        </x-surgicare.sidebar-nav-item>
    </nav>

    <div class="px-3 py-4 border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-white/80 hover:bg-white/10 hover:text-white transition-colors"
            >
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
