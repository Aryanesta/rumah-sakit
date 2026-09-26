<div {{ $attributes->class(['bg-rs-surface border border-rs-border rounded-2xl p-5 shadow-sm']) }}>
    <h3 class="font-semibold text-rs-text-primary mb-4">Akses Cepat</h3>
    <div class="space-y-3">
        <a href="{{ route('apps.angsmart.patients.index') }}" class="block w-full rounded-xl bg-rs-primary-light/30 border border-rs-primary/20 px-4 py-3 text-sm font-semibold text-rs-primary-dark text-center hover:bg-rs-primary-light/50 transition-colors">
            Lihat Pasien
        </a>
        <a href="{{ route('apps.angsmart.patients.nursing-care', 'budi-santoso') }}" class="block w-full rounded-xl bg-rs-primary-light/30 border border-rs-primary/20 px-4 py-3 text-sm font-semibold text-rs-primary-dark text-center hover:bg-rs-primary-light/50 transition-colors">
            Input Asuhan Keperawatan
        </a>
        <a href="{{ route('apps.angsmart.handover.index') }}" class="block w-full rounded-xl bg-rs-primary-light/30 border border-rs-primary/20 px-4 py-3 text-sm font-semibold text-rs-primary-dark text-center hover:bg-rs-primary-light/50 transition-colors">
            Handover
        </a>
        <a href="{{ route('apps.angsmart.reports.index') }}" class="block w-full rounded-xl bg-rs-primary-light/30 border border-rs-primary/20 px-4 py-3 text-sm font-semibold text-rs-primary-dark text-center hover:bg-rs-primary-light/50 transition-colors">
            Laporan
        </a>
    </div>
</div>
