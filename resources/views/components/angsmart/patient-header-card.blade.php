@props([
    'patient',
])

<div {{ $attributes->class(['bg-rs-surface border border-rs-border rounded-2xl p-5 shadow-sm']) }}>
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
        <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-rs-primary-light/50 text-rs-primary-dark">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </span>
        <div>
            <h2 class="text-xl font-bold text-rs-text-primary">{{ $patient['name'] }}</h2>
            <p class="mt-1 text-sm text-rs-text-secondary">
                No. RM {{ $patient['medical_record'] }}
                <span class="mx-1">|</span>
                Bed {{ $patient['bed'] }}
                <span class="mx-1">|</span>
                Usia {{ $patient['age'] }} th
            </p>
            <p class="mt-1 text-sm">
                <span class="text-rs-text-secondary">Diagnosis:</span>
                <span class="font-medium text-rs-text-primary">{{ $patient['diagnosis'] }}</span>
            </p>
        </div>
    </div>
</div>
