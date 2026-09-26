<aside class="hidden lg:flex w-64 flex-col bg-rs-primary-dark text-white shrink-0">
    <div class="px-5 py-6 border-b border-white/10">
        <a href="{{ route('apps.ansafe.index') }}" class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/15">
                <x-icons.ansafe class="h-6 w-6 text-white" />
            </span>
            <div>
                <p class="font-bold text-lg leading-tight">ANSafe</p>
                <p class="text-xs text-white/70">Pencegahan Risiko Jatuh</p>
            </div>
        </a>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-1" aria-label="Navigasi ANSafe">
        <x-ansafe.sidebar-nav-item
            :href="route('apps.ansafe.index')"
            :active="request()->routeIs('apps.ansafe.index')"
            label="Dashboard"
        >
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </x-slot:icon>
        </x-ansafe.sidebar-nav-item>

        <x-ansafe.sidebar-nav-item
            :href="route('apps.ansafe.patients.index')"
            :active="request()->routeIs('apps.ansafe.patients.index')"
            label="Daftar Pasien"
        >
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </x-slot:icon>
        </x-ansafe.sidebar-nav-item>

        <x-ansafe.sidebar-nav-item
            :href="route('apps.ansafe.patients.assessment', 'budi-santoso')"
            :active="request()->routeIs('apps.ansafe.patients.assessment')"
            label="Asesmen Risiko Jatuh"
        >
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </x-slot:icon>
        </x-ansafe.sidebar-nav-item>

        <x-ansafe.sidebar-nav-item
            :href="route('apps.ansafe.education.index')"
            :active="request()->routeIs('apps.ansafe.education.index')"
            label="Education Center"
        >
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </x-slot:icon>
        </x-ansafe.sidebar-nav-item>

        <x-ansafe.sidebar-nav-item
            :href="route('apps.ansafe.patients.family-monitoring', 'budi-santoso')"
            :active="request()->routeIs('apps.ansafe.patients.family-monitoring')"
            label="Monitoring Edukasi Keluarga"
        >
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </x-slot:icon>
        </x-ansafe.sidebar-nav-item>
    </nav>

    <div class="px-5 py-6 mt-auto border-t border-white/10 text-xs text-white/60 leading-relaxed">
        <p class="font-medium text-white/80">Ruang Angsoka 1</p>
        <p>RSUP Sanglah Denpasar</p>
    </div>
</aside>
