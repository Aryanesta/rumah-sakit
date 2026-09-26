@props([
    'label',
    'tone' => 'primary',
])

@php
    $classes = match ($tone) {
        'success' => 'bg-rs-success/20 text-rs-accent-dark border-rs-success/40',
        'warning' => 'bg-rs-warning/20 text-rs-warning border-rs-warning/40',
        'emergency' => 'bg-rs-emergency-light text-rs-emergency-dark border-rs-emergency/30',
        'info' => 'bg-rs-primary-light/40 text-rs-primary-dark border-rs-primary/30',
        'phase_pre' => 'bg-amber-100 text-amber-900 border-amber-200',
        'phase_post' => 'bg-rs-success/20 text-rs-accent-dark border-rs-success/40',
        default => 'bg-rs-primary/10 text-rs-primary border-rs-primary/20',
    };
@endphp

<span {{ $attributes->class(['inline-flex rounded-full border px-2.5 py-0.5 text-xs font-semibold', $classes]) }}>
    {{ $label }}
</span>
