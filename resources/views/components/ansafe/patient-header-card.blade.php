@props([
    'patient',
])

<div {{ $attributes->class(['bg-rs-surface border border-rs-border rounded-2xl p-5 shadow-sm']) }}>
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-start gap-4">
            <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-700">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </span>
            <div>
                <h1 class="text-xl font-bold text-rs-text-primary">{{ $patient['name'] }}</h1>
                <p class="mt-1 text-sm text-rs-text-secondary">
                    No. RM {{ $patient['medical_record'] }}
                    <span class="mx-1">|</span>
                    Bed {{ $patient['bed'] }}
                    <span class="mx-1">|</span>
                    Usia {{ $patient['age'] }} th
                </p>
                <p class="mt-1 text-sm text-rs-text-primary">
                    <span class="text-rs-text-secondary">Diagnosis:</span> {{ $patient['diagnosis'] }}
                </p>
            </div>
        </div>

        <div class="flex flex-col items-start sm:items-end gap-2">
            <x-ansafe.risk-badge :risk="$patient['risk']" />
            <p class="text-xs text-rs-text-secondary">
                Assessment terakhir {{ $patient['last_assessment_at'] }}
            </p>
        </div>
    </div>
</div>
