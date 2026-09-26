<x-angsmart-layout breadcrumb="Beranda › Rencana Keperawatan">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-rs-primary-dark">Rencana Keperawatan</h1>
            <p class="mt-2 text-sm text-rs-text-secondary">
                {{ $patient['name'] }} | No. RM {{ $patient['medical_record'] }} | Bed {{ $patient['bed'] }}
            </p>
        </div>
        <button
            type="button"
            x-data
            @click="$dispatch('open-add-diagnosis-modal')"
            class="inline-flex items-center gap-2 rounded-xl bg-rs-primary px-4 py-2.5 text-sm font-semibold text-white hover:bg-rs-primary-dark"
        >
            + Tambah Diagnosa
        </button>
    </div>

    @php
        $patientSlug = $patient['slug'];
        $tabs = [
            'diagnosa' => [
                'label' => 'Diagnosa Keperawatan',
                'href' => route('apps.angsmart.patients.care-plan', $patientSlug).'?tab=diagnosa',
            ],
            'tujuan' => [
                'label' => 'Tujuan & Kriteria Hasil',
                'href' => route('apps.angsmart.patients.care-plan', $patientSlug).'?tab=tujuan',
            ],
            'intervensi' => [
                'label' => 'Intervensi',
                'href' => route('apps.angsmart.patients.care-plan', $patientSlug).'?tab=intervensi',
            ],
            'evaluasi' => [
                'label' => 'Evaluasi',
                'href' => route('apps.angsmart.patients.care-plan', $patientSlug).'?tab=evaluasi',
            ],
        ];
    @endphp

    <x-angsmart.tabs :tabs="$tabs" :active="$activeTab" />

    @if ($activeTab === 'diagnosa')
        <div class="space-y-4">
            @foreach ($diagnoses as $index => $diagnosis)
                <div class="bg-rs-surface border border-rs-border rounded-2xl p-5 shadow-sm flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div class="flex-1">
                        <p class="text-xs text-rs-text-secondary mb-1">{{ $index + 1 }}.</p>
                        <h3 class="font-bold text-rs-primary-dark">{{ $diagnosis['title'] }}</h3>
                        <p class="mt-2 text-sm"><span class="text-rs-text-secondary">Tujuan:</span> {{ $diagnosis['goal'] }}</p>
                        <p class="mt-1 text-sm"><span class="text-rs-text-secondary">Intervensi:</span> {{ $diagnosis['intervention'] }}</p>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        <x-angsmart.status-badge :label="$diagnosis['status']->label()" tone="success" />
                        <button type="button" class="rounded-xl border border-rs-border px-4 py-2 text-sm font-semibold hover:bg-rs-background">
                            Edit
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        @include('apps.angsmart.partials.add-diagnosis-modal', ['masterDiagnoses' => $masterDiagnoses])
    @else
        <div class="bg-rs-surface border border-rs-border rounded-2xl p-8 text-center text-sm text-rs-text-secondary">
            Konten tab ini akan diisi pada pengembangan berikutnya (mode demo).
        </div>
    @endif
</x-angsmart-layout>
