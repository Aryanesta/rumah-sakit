<aside class="flex w-64 h-full min-h-screen flex-col bg-rs-primary-dark text-white shrink-0">
    <div class="px-5 py-6 border-b border-white/10">
        <a href="{{ route('apps.angsmart.index') }}" class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/15">
                <x-icons.angsmart class="h-6 w-6 text-white" />
            </span>
            <div>
                <p class="font-bold text-lg leading-tight">ANGSMART</p>
                <p class="text-xs text-white/70">Integrated Health System</p>
            </div>
        </a>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-1" aria-label="Navigasi Angsmart">
        <x-angsmart.sidebar-nav-item
            :href="route('apps.angsmart.index')"
            :active="request()->routeIs('apps.angsmart.index')"
            label="Dashboard"
        >
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </x-slot:icon>
        </x-angsmart.sidebar-nav-item>

        <x-angsmart.sidebar-nav-item
            :href="route('apps.angsmart.patients.index')"
            :active="request()->routeIs('apps.angsmart.patients.*')"
            label="Patient List"
        >
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </x-slot:icon>
        </x-angsmart.sidebar-nav-item>

        <x-angsmart.sidebar-nav-item
            :href="route('apps.angsmart.patients.nursing-care', 'budi-santoso')"
            :active="request()->routeIs('apps.angsmart.patients.nursing-care')"
            label="Asuhan Keperawatan"
        >
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </x-slot:icon>
        </x-angsmart.sidebar-nav-item>

        <x-angsmart.sidebar-nav-item
            :href="route('apps.angsmart.handover.index')"
            :active="request()->routeIs('apps.angsmart.handover.*')"
            label="Handover"
        >
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </x-slot:icon>
        </x-angsmart.sidebar-nav-item>

        <x-angsmart.sidebar-nav-item
            :href="route('apps.angsmart.patients.care-plan', 'budi-santoso')"
            :active="request()->routeIs('apps.angsmart.patients.care-plan')"
            label="Rencana Keperawatan"
        >
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </x-slot:icon>
        </x-angsmart.sidebar-nav-item>

        <x-angsmart.sidebar-nav-item
            :href="route('apps.angsmart.reports.index')"
            :active="request()->routeIs('apps.angsmart.reports.*')"
            label="Laporan"
        >
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </x-slot:icon>
        </x-angsmart.sidebar-nav-item>
    </nav>

    <div class="px-3 py-4 border-t border-white/10 space-y-1">
        <x-angsmart.sidebar-nav-item
            :href="route('profile.edit')"
            :active="request()->routeIs('profile.edit')"
            label="Profil"
        >
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </x-slot:icon>
        </x-angsmart.sidebar-nav-item>

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
