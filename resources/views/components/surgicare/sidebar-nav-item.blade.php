@props([
    'href',
    'label',
    'active' => false,
])

<a
    href="{{ $href }}"
    @class([
        'flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors',
        'bg-white/15 text-white ring-1 ring-white/20' => $active,
        'text-white/80 hover:bg-white/10 hover:text-white' => ! $active,
    ])
>
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
        {{ $icon }}
    </svg>
    <span>{{ $label }}</span>
</a>
