<div {{ $attributes->class(['bg-rs-surface border border-rs-border rounded-2xl p-5 shadow-sm angsmart-surface']) }}>
    <h3 class="font-semibold text-rs-text-primary mb-4">Akses Cepat</h3>
    <div class="space-y-2">
        <a href="{{ route('apps.angsmart.patients.index') }}" class="block w-full rounded-xl bg-rs-primary px-4 py-3 text-sm font-semibold text-white text-center hover:bg-rs-primary-dark transition-colors duration-200">
            Lihat Pasien
        </a>
        <a href="{{ route('apps.angsmart.patients.nursing-care', 'budi-santoso') }}" class="block w-full rounded-xl bg-rs-primary-light px-4 py-3 text-sm font-semibold text-white text-center hover:bg-rs-primary transition-colors duration-200">
            Input Asuhan Keperawatan
        </a>
        <a href="{{ route('apps.angsmart.handover.index') }}" class="block w-full rounded-xl border border-rs-border px-4 py-3 text-sm font-semibold text-rs-text-primary text-center hover:bg-rs-background transition-colors duration-200">
            Handover
        </a>
        <a href="{{ route('apps.angsmart.reports.index') }}" class="block w-full rounded-xl border border-rs-border px-4 py-3 text-sm font-semibold text-rs-text-primary text-center hover:bg-rs-background transition-colors duration-200">
            Laporan
        </a>
    </div>
</div>
