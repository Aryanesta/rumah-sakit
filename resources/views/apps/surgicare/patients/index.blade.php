<x-surgicare-layout breadcrumb="Beranda › Patient List">
    <x-surgicare.page-header title="Patient List" />

    <div
        x-data="surgicarePatientTable(@js($patients))"
        class="space-y-4"
    >
        @include('apps.surgicare.partials.patient-filters', [
            'phaseOptions' => $phaseOptions,
        ])

        @include('apps.surgicare.partials.patient-table')
    </div>
</x-surgicare-layout>
