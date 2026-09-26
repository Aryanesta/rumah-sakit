<x-ansafe-layout pageTitle="Daftar Pasien">
    <x-ansafe.page-header
        title="Daftar Pasien"
        subtitle="Cari dan filter pasien untuk melihat atau memperbarui asesmen risiko jatuh."
    />

    @include('apps.ansafe.partials.patient-table', [
        'patients' => $patients,
        'roomOptions' => $roomOptions,
    ])
</x-ansafe-layout>
