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

        @include('apps.angsmart.partials.patient-table')
    </div>
</x-angsmart-layout>
