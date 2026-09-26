<x-surgicare-layout breadcrumb="Beranda › Patient List">
    <x-surgicare.page-header title="Patient List" />

    <div
        x-data="surgicarePatientTable(@js($patients))"
        class="space-y-4"
    >
        @include('apps.surgicare.partials.patient-filters', [
            'phaseOptions' => $phaseOptions,
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

        @include('apps.surgicare.partials.patient-table')

        @include('apps.surgicare.partials.add-patient-modal')
    </div>
</x-surgicare-layout>
