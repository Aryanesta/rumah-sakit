@props([
    'href',
    'label',
    'icon',
    'variant' => 'surface',
])

@php
    $cardClasses = match ($icon) {
        'surgicare' => 'bg-emerald-50 border-2 border-emerald-400 hover:border-emerald-500 hover:bg-emerald-100/60',
        'angsmart' => 'bg-blue-50 border-2 border-blue-400 hover:border-blue-500 hover:bg-blue-100/60',
        'ansafe' => 'bg-amber-50 border-2 border-amber-400 hover:border-amber-500 hover:bg-amber-100/60',
        default => 'bg-rs-background border-2 border-rs-border hover:border-rs-text-secondary',
    };

    $titleClasses = match ($icon) {
        'surgicare' => 'text-emerald-950',
        'angsmart' => 'text-blue-950',
        'ansafe' => 'text-amber-950',
        default => 'text-rs-text-primary',
    };

    $ctaClasses = match ($icon) {
        'surgicare' => 'text-emerald-800',
        'angsmart' => 'text-blue-800',
        'ansafe' => 'text-amber-800',
        default => 'text-rs-primary-dark',
    };

    $iconColorClasses = match ($icon) {
        'surgicare' => 'text-emerald-600',
        'angsmart' => 'text-blue-600',
        'ansafe' => 'text-amber-600',
        default => 'text-rs-text-secondary',
    };
@endphp

<a
    href="{{ $href }}"
    {{ $attributes->class([
        'group relative flex min-h-[150px] sm:min-h-[165px] flex-col overflow-hidden rounded-2xl p-5 sm:p-6 shadow-sm transition-[box-shadow,background-color,border-color] duration-300 ease-out hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-rs-primary/50 focus-visible:ring-offset-2 focus-visible:ring-offset-white',
        $cardClasses,
    ]) }}
>
    <h2 @class([
        'relative z-10 text-2xl sm:text-3xl font-bold tracking-tight pr-24 sm:pr-28',
        $titleClasses,
    ])>
        {{ $label }}
    </h2>

    <div @class([
        'absolute bottom-5 left-5 sm:bottom-6 sm:left-6 z-10 flex items-center gap-2 opacity-0 translate-y-2 transition-all duration-300 ease-out group-hover:opacity-100 group-hover:translate-y-0 group-focus-visible:opacity-100 group-focus-visible:translate-y-0',
        $ctaClasses,
    ])>
        <span class="text-sm font-semibold uppercase tracking-wide">Buka modul</span>
        <svg class="h-4 w-4 transition-transform duration-300 ease-out group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
        </svg>
    </div>

    <div class="absolute -bottom-3 -right-3 sm:-bottom-4 sm:-right-4 w-28 h-28 sm:w-32 sm:h-32 pointer-events-none select-none transition-transform duration-500 group-hover:scale-105 {{ $iconColorClasses }}">
        @include('components.icons.'.$icon, ['class' => 'h-full w-full text-current'])
    </div>
</a>
