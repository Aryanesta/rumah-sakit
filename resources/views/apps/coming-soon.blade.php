<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="font-semibold text-xl text-rs-text-primary leading-tight">
                {{ $moduleName }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-rs-primary hover:text-rs-primary-dark transition-colors">
                ← Kembali ke pemilih aplikasi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-rs-surface border border-rs-border rounded-2xl p-8 text-center shadow-sm">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-rs-primary-light/40 text-rs-primary">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                        <circle cx="12" cy="12" r="9"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-rs-text-primary">Modul sedang disiapkan</h3>
                <p class="mt-2 text-sm text-rs-text-secondary leading-relaxed">
                    Halaman {{ $moduleName }} akan tersedia pada rilis berikutnya. Anda dapat kembali ke layar pemilih aplikasi untuk membuka modul lain.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
