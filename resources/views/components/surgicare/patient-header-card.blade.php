@props([
    'patient',
    'checklistType' => 'pre_op',
])

@php
    use App\Enums\Angsmart\SurgicalPhase;

    $phase = $patient['phase'] instanceof SurgicalPhase
        ? $patient['phase']
        : ($patient['phase'] === 'pre_op' ? SurgicalPhase::PreOp : SurgicalPhase::PostOp);

    $phaseLabel = $phase === SurgicalPhase::PreOp ? 'Pre-Op' : 'Post-Op';
    $phaseTone = $phase === SurgicalPhase::PreOp ? 'phase_pre' : 'phase_post';
@endphp

<div {{ $attributes->class(['bg-rs-surface border border-rs-border rounded-2xl p-5 shadow-sm']) }}>
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-rs-primary-light/40 text-rs-primary-dark overflow-hidden">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </span>
            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <h2 class="text-xl font-bold text-rs-text-primary">{{ $patient['name'] }}</h2>
                    <x-surgicare.status-badge :label="$phaseLabel" :tone="$phaseTone" />
                </div>
                <p class="mt-1 text-sm text-rs-text-secondary">
                    No. RM {{ $patient['medical_record'] }}
                    <span class="mx-1">|</span>
                    {{ $patient['age'] }} Tahun
                    <span class="mx-1">|</span>
                    {{ $patient['diagnosis'] }}
                </p>
            </div>
        </div>
        <a
            href="{{ route('apps.surgicare.patients.index') }}"
            class="inline-flex shrink-0 items-center justify-center rounded-xl border border-rs-primary px-4 py-2 text-sm font-semibold text-rs-primary hover:bg-rs-primary/5 transition-colors"
        >
            Kembali ke List
        </a>
    </div>
</div>
