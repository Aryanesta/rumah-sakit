@props([
    'title',
    'subtitle' => null,
    'showDate' => false,
])

<div {{ $attributes->class(['mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between']) }}>
    <div>
        <h1 class="text-2xl font-bold text-rs-primary-dark">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-1 text-sm text-rs-text-secondary max-w-3xl">{{ $subtitle }}</p>
        @endif
    </div>
    @if ($showDate)
        <p class="text-sm text-rs-text-secondary">{{ now()->translatedFormat('d F Y') }}</p>
    @endif
</div>
