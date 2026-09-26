@props([
    'risk',
])

@php
    use App\Enums\Ansafe\FallRiskCategory;

    $category = $risk instanceof FallRiskCategory
        ? $risk
        : FallRiskCategory::from((string) $risk);

    $classes = match ($category) {
        FallRiskCategory::Rendah => 'bg-rs-success/20 text-rs-accent-dark border-rs-success/40',
        FallRiskCategory::Sedang => 'bg-rs-warning/20 text-rs-warning border-rs-warning/40',
        FallRiskCategory::Tinggi => 'bg-rs-emergency-light text-rs-emergency-dark border-rs-emergency/30',
    };
@endphp

<span {{ $attributes->class(['inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold', $classes]) }}>
    {{ $category->label() }}
</span>
