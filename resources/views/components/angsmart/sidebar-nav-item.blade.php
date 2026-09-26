@props([
    'href',
    'label',
    'active' => false,
])

<a
    href="{{ $href }}"
    @class([
        'flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors duration-200',
        'bg-rs-primary-dark text-white' => $active,
        'text-white hover:bg-white/10' => ! $active,
    ])
>
    <svg class="h-7 w-7 shrink-0 text-white/35" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
        {{ $icon }}
    </svg>
    <span class="text-white">{{ $label }}</span>
</a>
