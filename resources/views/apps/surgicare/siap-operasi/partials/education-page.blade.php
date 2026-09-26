@php
    $trackItems = $progress['checklists'][$track] ?? [];
    $masterIds = array_column($page['master_checklist']['items'], 'id');
@endphp

<x-siap-operasi-layout :breadcrumb="$page['title']">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-rs-primary-dark">{{ $page['title'] }}</h2>
        <p class="mt-2 text-sm text-rs-text-secondary">{{ $page['intro'] }}</p>
    </div>

    <div
        x-data="siapOperasiEducationChecklist(@js([
            'track' => $track,
            'saveUrl' => $checklistSaveUrl,
            'initialItems' => $trackItems,
            'masterIds' => $masterIds,
            'feedbackPartial' => $page['master_checklist']['feedback_partial'],
            'feedbackComplete' => $page['master_checklist']['feedback_complete'],
        ]))"
        class="space-y-6"
    >
        @foreach ($page['blocks'] as $block)
            <details class="group bg-rs-surface border border-rs-border rounded-2xl shadow-sm overflow-hidden" @if($loop->first) open @endif>
                <summary class="cursor-pointer px-5 py-4 font-semibold text-rs-text-primary list-none flex items-center justify-between">
                    <span>{{ $block['heading'] }}</span>
                    <span class="text-rs-text-secondary text-sm group-open:rotate-180 transition-transform">▼</span>
                </summary>
                <div class="px-5 pb-5 space-y-4 border-t border-rs-border pt-4">
                    @foreach ($block['body'] as $paragraph)
                        <p class="text-sm text-rs-text-secondary">{{ $paragraph }}</p>
                    @endforeach

                    @if (! empty($block['checklist']))
                        <ul class="space-y-2">
                            @foreach ($block['checklist'] as $item)
                                <li class="flex items-start gap-3 rounded-xl border border-rs-border px-3 py-2.5">
                                    <input
                                        type="checkbox"
                                        class="mt-0.5 h-5 w-5 rounded border-rs-border text-rs-primary focus:ring-rs-primary"
                                        :checked="isChecked(@js($item['id']))"
                                        @change="toggle(@js($item['id']), $event)"
                                    />
                                    <span class="text-sm">{{ $item['label'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    @if ($block['key'] === 'c' && ! empty($page['dont_do'] ?? null))
                        <ul class="list-disc pl-5 text-sm text-rs-text-secondary space-y-1">
                            @foreach ($page['dont_do'] as $line)
                                <li>{{ $line }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </details>
        @endforeach

        @if (! empty($page['dont_do'] ?? null) && collect($page['blocks'])->where('key', 'c')->isEmpty())
            <div class="bg-rs-surface border border-rs-border rounded-2xl p-5 shadow-sm">
                <h3 class="font-semibold mb-3">Jangan melakukan tanpa instruksi</h3>
                <ul class="list-disc pl-5 text-sm text-rs-text-secondary space-y-1">
                    @foreach ($page['dont_do'] as $line)
                        <li>{{ $line }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-rs-surface border border-rs-border rounded-2xl p-5 shadow-sm">
            <h3 class="font-semibold text-rs-text-primary mb-4">{{ $page['master_checklist']['title'] }}</h3>
            <ul class="space-y-2">
                @foreach ($page['master_checklist']['items'] as $item)
                    <li class="flex items-start gap-3 rounded-xl border border-rs-border px-3 py-2.5">
                        <input
                            type="checkbox"
                            class="mt-0.5 h-5 w-5 rounded border-rs-border text-rs-primary focus:ring-rs-primary"
                            :checked="isChecked(@js($item['id']))"
                            @change="toggle(@js($item['id']), $event)"
                        />
                        <span class="text-sm">{{ $item['label'] }}</span>
                    </li>
                @endforeach
            </ul>
            <p x-show="message" x-cloak x-text="message" class="mt-4 text-sm font-medium text-rs-primary-dark"></p>
        </div>

        @isset($page['question_notes_title'])
            <div class="bg-rs-surface border border-rs-border rounded-2xl p-5 shadow-sm">
                <h3 class="font-semibold mb-2">{{ $page['question_notes_title'] }}</h3>
                <textarea rows="4" class="w-full rounded-xl border-rs-border text-sm" placeholder="{{ $page['question_notes_placeholder'] }}" readonly>{{ $progress['family_question_notes'] ?? '' }}</textarea>
                <p class="text-xs text-rs-text-secondary mt-2">Catatan lokal (mode demo — belum disimpan ke server).</p>
            </div>
        @endisset

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('apps.surgicare.siap-operasi.index') }}" class="rounded-xl border border-rs-border px-4 py-2 text-sm font-semibold">Kembali ke Dashboard</a>
            <a href="{{ route('apps.surgicare.siap-operasi.siap-check') }}" class="rounded-xl bg-rs-primary px-4 py-2 text-sm font-semibold text-white hover:bg-rs-primary-dark">SIAP Check</a>
        </div>
    </div>
</x-siap-operasi-layout>
