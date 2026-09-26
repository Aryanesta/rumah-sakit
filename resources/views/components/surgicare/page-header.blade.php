@props([
    'title',
    'subtitle' => null,
])

<div {{ $attributes->class(['mb-6']) }}>
    <h1 class="text-2xl font-bold text-rs-primary-dark">{{ $title }}</h1>
    @if ($subtitle)
        <p class="mt-1 text-sm text-rs-text-secondary max-w-3xl">{{ $subtitle }}</p>
    @endif
</div>
