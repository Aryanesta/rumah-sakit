@props([
    'label',
    'value',
    'tone' => 'primary',
    'stagger' => '',
])

@php
    $cardTones = [
        'primary' => 'bg-rs-primary',
        'accent' => 'bg-rs-primary-light',
        'success' => 'bg-emerald-500',
        'warning' => 'bg-yellow-400',
        'emergency' => 'bg-rs-emergency-dark',
    ];
    $cardBg = $cardTones[$tone] ?? $cardTones['primary'];
    $numericValue = (int) $value;
@endphp

<div
    x-data="angsmartStatCount({{ $numericValue }})"
    {{ $attributes->class([
        'group relative overflow-hidden rounded-2xl p-5 sm:p-6 shadow-sm min-h-[128px]',
        'angsmart-surface hover:shadow-md hover:-translate-y-0.5',
        'animate-element',
        $stagger,
        $cardBg,
    ]) }}
>
    <div class="relative z-10">
        <p class="text-base sm:text-lg font-medium text-white/90 leading-snug">{{ $label }}</p>
        <p
            class="mt-2 text-4xl sm:text-5xl font-bold text-white tabular-nums tracking-tight"
            x-text="displayValue"
        >{{ $numericValue }}</p>
    </div>

    <div
        class="pointer-events-none absolute -bottom-2 -right-2 h-24 w-24 select-none text-white/20"
        aria-hidden="true"
    >
        <div class="h-full w-full text-white group-hover:animate-shake">
            {{ $icon ?? '' }}
        </div>
    </div>
</div>
