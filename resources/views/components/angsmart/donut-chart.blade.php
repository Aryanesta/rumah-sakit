@props([
    'percent',
    'completed',
    'total',
])

<div {{ $attributes->class(['flex flex-col items-center justify-center']) }}>
    <div
        class="relative h-40 w-40 rounded-full"
        style="background: conic-gradient(#0564F5 0 {{ $percent }}%, #EFEFEF {{ $percent }}% 100%);"
        role="img"
        aria-label="Tindakan selesai {{ $percent }} persen"
    >
        <div class="absolute inset-4 rounded-full bg-rs-surface flex flex-col items-center justify-center text-center">
            <span class="text-3xl font-bold text-rs-primary">{{ $percent }}%</span>
        </div>
    </div>
    <p class="mt-4 text-sm text-rs-text-secondary text-center">
        Tindakan Selesai: <span class="font-semibold text-rs-text-primary">{{ $completed }}</span> dari {{ $total }} pasien
    </p>
</div>
