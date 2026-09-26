<x-ansafe-layout breadcrumb="Beranda › Dashboard ANSafe">
    <div class="mb-6 rounded-2xl border border-rs-border bg-gradient-to-r from-rs-primary-light/40 to-rs-surface p-6 sm:p-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-rs-primary-dark">ANSafe: Pencegahan Risiko Jatuh Pasien</h1>
                <p class="mt-2 text-sm text-rs-text-secondary max-w-2xl">
                    Pantau risiko jatuh, lakukan asesmen Morse Fall Scale, dan edukasi pasien serta keluarga dalam satu modul terpadu.
                </p>
            </div>
            <div class="hidden sm:block h-24 w-40 rounded-2xl bg-rs-primary/10 border border-rs-primary/20" aria-hidden="true"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4 mb-8">
        <x-ansafe.stat-card label="Total Pasien" :value="$stats['total']" tone="primary">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </x-slot:icon>
        </x-ansafe.stat-card>
        <x-ansafe.stat-card label="Risiko Rendah" :value="$stats['rendah']" tone="success">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-slot:icon>
        </x-ansafe.stat-card>
        <x-ansafe.stat-card label="Risiko Sedang" :value="$stats['sedang']" tone="warning">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </x-slot:icon>
        </x-ansafe.stat-card>
        <x-ansafe.stat-card label="Risiko Tinggi" :value="$stats['tinggi']" tone="emergency">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-slot:icon>
        </x-ansafe.stat-card>
        <x-ansafe.stat-card label="Edukasi Belum Diakses" :value="$stats['education_pending']" tone="accent">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </x-slot:icon>
        </x-ansafe.stat-card>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 space-y-4">
            <x-ansafe.page-header
                title="Monitoring Pasien"
                subtitle="Daftar pasien aktif dengan tingkat risiko jatuh terbaru."
            />
            @include('apps.ansafe.partials.patient-table', [
                'patients' => $patients,
                'roomOptions' => $roomOptions,
            ])
        </div>

        <div class="space-y-6">
            <div class="bg-rs-surface border border-rs-border rounded-2xl p-5 shadow-sm">
                <h3 class="font-semibold text-rs-text-primary mb-4">Pasien dengan Risiko Tinggi</h3>
                <ul class="space-y-3">
                    @foreach ($highRiskPatients as $highRisk)
                        <li class="flex items-center justify-between gap-2 text-sm">
                            <span class="font-medium text-rs-text-primary">{{ $highRisk['name'] }}</span>
                            <a
                                href="{{ route('apps.ansafe.patients.assessment', $highRisk['slug']) }}"
                                class="text-rs-primary font-semibold hover:text-rs-primary-dark"
                            >Lihat</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-rs-surface border border-rs-border rounded-2xl p-5 shadow-sm space-y-2">
                <h3 class="font-semibold text-rs-text-primary mb-3">Aksi Cepat</h3>
                <a href="{{ route('apps.ansafe.patients.assessment', 'budi-santoso') }}" class="block w-full rounded-xl bg-rs-primary px-4 py-3 text-sm font-semibold text-white text-center hover:bg-rs-primary-dark transition-colors">
                    Assessment Risiko Jatuh
                </a>
                <a href="{{ route('apps.ansafe.education.index') }}" class="block w-full rounded-xl bg-rs-accent px-4 py-3 text-sm font-semibold text-rs-text-primary text-center hover:bg-rs-accent-dark hover:text-white transition-colors">
                    Edukasi Pasien &amp; Keluarga
                </a>
                <a href="{{ route('apps.ansafe.patients.family-monitoring', 'budi-santoso') }}" class="block w-full rounded-xl border border-rs-border px-4 py-3 text-sm font-semibold text-rs-text-primary text-center hover:bg-rs-background transition-colors">
                    Monitoring Edukasi Keluarga
                </a>
            </div>
        </div>
    </div>
</x-ansafe-layout>
