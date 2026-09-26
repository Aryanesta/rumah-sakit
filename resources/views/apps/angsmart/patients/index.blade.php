<x-angsmart-layout pageTitle="Patient List">
    <x-angsmart.page-header
        title="Patient List"
        subtitle="Cari dan filter pasien untuk asuhan keperawatan dan handover."
        class="animate-element animate-delay-100"
    />

    <div
        x-data="angsmartPatientTable(@js($patients))"
        class="space-y-4 animate-element animate-delay-200"
    >
        @include('apps.angsmart.partials.patient-filters', [
            'phaseOptions' => $phaseOptions,
            'statusOptions' => $statusOptions,
        ])

        @include('apps.angsmart.partials.patient-table')
    </div>
</x-angsmart-layout>
