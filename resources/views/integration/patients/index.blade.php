<x-launcher-layout>
    <div class="animate-page-enter w-full max-w-6xl">
        <nav class="mb-6 text-sm text-rs-text-secondary">
            <a href="{{ route('dashboard') }}" class="hover:text-rs-primary font-medium">Beranda</a>
            <span class="mx-2" aria-hidden="true">›</span>
            <span class="text-rs-text-primary font-semibold">Manajemen Data Pasien</span>
        </nav>

        <div
            x-data="integrationPatientCrud(@js($patients), @js($phaseOptions), @js($genderOptions))"
            class="space-y-4"
        >
            <header class="mb-4 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-rs-text-primary">
                        Manajemen Data Pasien
                    </h1>
                    <p class="mt-2 text-sm sm:text-base text-rs-text-secondary">
                        Kelola data master pasien. Mode demo — perubahan hanya di browser hingga tersambung ke database.
                    </p>
                </div>
                <button
                    type="button"
                    @click="openCreateForm()"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-rs-primary px-4 py-2.5 text-sm font-semibold text-white hover:bg-rs-primary-dark transition-colors shrink-0"
                >
                    <span aria-hidden="true">+</span>
                    Tambah Pasien
                </button>
            </header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <label class="sr-only" for="patient-search">Cari pasien</label>
                <input
                    id="patient-search"
                    type="search"
                    x-model="search"
                    @input="page = 1"
                    placeholder="Cari nama, No. RM, atau kamar..."
                    class="w-full sm:max-w-md rounded-xl border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary"
                />
            </div>

            @include('integration.patients.partials.patient-table')
            @include('integration.patients.partials.patient-form-modal')
            @include('integration.patients.partials.delete-patient-modal')
        </div>
    </div>
</x-launcher-layout>
