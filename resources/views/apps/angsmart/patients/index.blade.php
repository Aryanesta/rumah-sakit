<x-angsmart-layout breadcrumb="Beranda › Patient List">
    <x-angsmart.page-header title="Patient List" :show-date="true" />

    <div
        x-data="angsmartPatientTable(@js($patients))"
        class="space-y-4"
    >
        @include('apps.angsmart.partials.patient-filters', [
            'phaseOptions' => $phaseOptions,
            'statusOptions' => $statusOptions,
        ])

        <div class="flex justify-end">
            <button
                type="button"
                @click="$dispatch('open-add-patient-modal')"
                class="inline-flex items-center gap-2 rounded-xl bg-rs-primary px-4 py-2.5 text-sm font-semibold text-white hover:bg-rs-primary-dark transition-colors"
            >
                <span aria-hidden="true">+</span>
                Tambah Pasien
            </button>
        </div>

        @include('apps.angsmart.partials.patient-table')

        @include('apps.angsmart.partials.add-patient-modal')
    </div>
</x-angsmart-layout>
