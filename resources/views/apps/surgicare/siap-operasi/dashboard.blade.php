<x-siap-operasi-layout breadcrumb="Dashboard SIAP OPERASI">
    <div class="space-y-6">
        <div>
            <h2 class="text-2xl font-bold text-rs-primary-dark">{{ $content['title'] }}</h2>
            <p class="text-sm text-rs-text-secondary mt-1">{{ $content['subtitle'] }}</p>
            <p class="text-sm font-medium text-rs-primary mt-2">{{ $content['tagline'] }}</p>
        </div>

        <p class="text-sm text-rs-text-secondary leading-relaxed">{{ $content['intro'] }}</p>

        <div class="rounded-2xl border border-rs-warning/40 bg-rs-warning/10 px-4 py-3">
            <p class="text-xs font-bold text-rs-text-primary mb-1">Penting</p>
            <p class="text-sm text-rs-text-secondary">{{ $content['important_notice'] }}</p>
        </div>

        <div class="grid gap-4">
            @foreach ($content['menu_cards'] as $card)
                <a href="{{ route($card['route']) }}" class="block rounded-2xl border border-rs-border bg-rs-surface p-5 shadow-sm hover:border-rs-primary/40 transition-colors">
                    <h3 class="font-bold text-rs-primary-dark">{{ $card['title'] }}</h3>
                    <p class="text-sm text-rs-text-secondary mt-2">{{ $card['description'] }}</p>
                </a>
            @endforeach
        </div>

        <a href="{{ route($content['siap_check_cta']['route']) }}" class="block rounded-2xl border-2 border-rs-primary bg-rs-primary/5 p-5">
            <h3 class="font-bold text-rs-primary-dark">{{ $content['siap_check_cta']['title'] }}</h3>
            <p class="text-sm text-rs-text-secondary mt-2">{{ $content['siap_check_cta']['description'] }}</p>
        </a>
    </div>
</x-siap-operasi-layout>
