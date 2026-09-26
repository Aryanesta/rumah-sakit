@php
    $questionsForJs = collect($questions)->map(function (array $q) {
        $q['review_url'] = route($q['review_route']);

        return $q;
    })->values()->all();
@endphp

<x-siap-operasi-layout breadcrumb="SIAP Check">
    <div
        x-data="siapOperasiQuiz(@js($questionsForJs), @js($submitUrl), @js($finalMessages))"
        class="space-y-6"
    >
        <div x-show="!finished">
            <h2 class="text-2xl font-bold text-rs-primary-dark">SIAP Check</h2>
            <p class="mt-2 text-sm text-rs-text-secondary">{{ $intro }}</p>
            <p class="text-xs text-rs-text-secondary mt-1">{{ $metaLabel }}</p>

            <div class="mt-6 bg-rs-surface border border-rs-border rounded-2xl p-5 shadow-sm">
                <p class="text-xs text-rs-text-secondary mb-2" x-text="`Pertanyaan ${step + 1} dari ${questions.length}`"></p>
                <p class="font-semibold text-rs-text-primary" x-text="currentQuestion().prompt"></p>

                <ul class="mt-4 space-y-2">
                    <template x-for="option in currentQuestion().options" :key="option">
                        <li>
                            <button
                                type="button"
                                class="w-full text-left rounded-xl border border-rs-border px-4 py-3 text-sm hover:border-rs-primary disabled:opacity-50"
                                :disabled="showFeedback"
                                @click="selectOption(option)"
                                x-text="option"
                            ></button>
                        </li>
                    </template>
                </ul>

                <div x-show="showFeedback" x-cloak class="mt-4 rounded-xl border px-4 py-3 text-sm" :class="lastCorrect ? 'border-rs-success/40 bg-rs-success/10' : 'border-rs-warning/40 bg-rs-warning/10'">
                    <p x-text="feedbackText"></p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <button type="button" @click="nextStep()" class="rounded-lg bg-rs-primary px-4 py-2 text-xs font-semibold text-white" x-text="step < questions.length - 1 ? 'Lanjut' : 'Selesai'"></button>
                        <a x-show="!lastCorrect" :href="currentQuestion().review_url" class="rounded-lg border border-rs-primary px-4 py-2 text-xs font-semibold text-rs-primary">PELAJARI KEMBALI</a>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="finished" x-cloak class="bg-rs-surface border border-rs-border rounded-2xl p-6 shadow-sm space-y-4">
            <p class="text-lg font-bold" :class="resultGood ? 'text-rs-success' : 'text-rs-warning'" x-text="resultGood ? finalMessages.good : finalMessages.needs_review"></p>
            <p class="text-sm text-rs-text-secondary">{{ $finalMessages['closing'] }}</p>
            <div>
                <p class="text-sm font-semibold mb-2">MATERI YANG SUDAH ANDA PELAJARI</p>
                <ul class="text-sm text-rs-text-secondary space-y-1">
                    @foreach ($studiedMaterials as $material)
                        <li>☑ {{ $material }}</li>
                    @endforeach
                </ul>
            </div>
            <p class="text-sm text-rs-text-secondary">Masih ada yang ingin ditanyakan? Sampaikan kepada perawat yang merawat Anda.</p>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('apps.surgicare.siap-operasi.index') }}" class="rounded-xl border border-rs-border px-4 py-2 text-sm font-semibold">Dashboard</a>
                <a href="{{ route('apps.surgicare.siap-operasi.sebelum') }}" class="rounded-xl bg-rs-primary px-4 py-2 text-sm font-semibold text-white">PELAJARI KEMBALI</a>
            </div>
        </div>
    </div>
</x-siap-operasi-layout>
