@props([
    'label',
    'value',
    'tone' => 'primary',
])

@php
    $tones = [
        'primary' => 'bg-rs-primary/10 text-rs-primary border-rs-primary/20',
        'success' => 'bg-rs-success/15 text-rs-accent-dark border-rs-success/30',
        'warning' => 'bg-rs-warning/15 text-rs-warning border-rs-warning/30',
        'emergency' => 'bg-rs-emergency-light text-rs-emergency-dark border-rs-emergency/20',
        'accent' => 'bg-rs-accent/20 text-rs-accent-dark border-rs-accent/30',
    ];
    $iconTone = $tones[$tone] ?? $tones['primary'];
@endphp

<div {{ $attributes->class(['bg-rs-surface border border-rs-border rounded-2xl p-5 shadow-sm']) }}>
    <div class="flex items-start justify-between gap-3">
        <div>
            <p class="text-sm text-rs-text-secondary">{{ $label }}</p>
            <p class="mt-2 text-3xl font-bold text-rs-text-primary tabular-nums">{{ $value }}</p>
        </div>
        <span @class(['flex h-11 w-11 items-center justify-center rounded-xl border', $iconTone])>
            {{ $icon ?? '' }}
        </span>
    </div>
</div>
