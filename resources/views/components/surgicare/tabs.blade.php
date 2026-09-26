@props([
    'tabs',
    'active',
])

<nav class="flex flex-wrap gap-4 border-b border-rs-border mb-6" aria-label="Tab navigasi">
    @foreach ($tabs as $key => $tab)
        <a
            href="{{ $tab['href'] }}"
            @class([
                'pb-3 text-sm font-semibold border-b-2 -mb-px transition-colors',
                'border-rs-primary text-rs-primary' => $active === $key,
                'border-transparent text-rs-text-secondary hover:text-rs-text-primary' => $active !== $key,
            ])
        >
            {{ $tab['label'] }}
        </a>
    @endforeach
</nav>
