<x-surgicare-layout breadcrumb="Beranda › Post-Op Checklist">
    <x-surgicare.page-header title="Post-Op Checklist" />

    <x-surgicare.patient-header-card :patient="$patient" class="mb-6" />

    @php
        $patientSlug = $patient['slug'];
        $base = route('apps.surgicare.patients.post-op-checklist', $patientSlug);
        $tabs = [
            'data' => ['label' => 'Data Pasien', 'href' => $base.'?tab=data'],
            'checklist' => ['label' => 'Checklist', 'href' => $base.'?tab=checklist'],
            'catatan' => ['label' => 'Catatan', 'href' => $base.'?tab=catatan'],
        ];
    @endphp

    <x-surgicare.tabs :tabs="$tabs" :active="$activeTab" />

    @if ($activeTab === 'checklist')
        <div
            x-data="surgicareChecklistForm(@js($sections))"
            class="bg-rs-surface border border-rs-border rounded-2xl p-6 shadow-sm space-y-8"
        >
            <template x-for="(section, sectionIndex) in sections" :key="section.title">
                <div>
                    <h3 class="font-semibold text-rs-text-primary mb-4">
                        <span x-text="(sectionIndex + 1) + '. ' + section.title"></span>
                    </h3>

                    <template x-if="section.type === 'select'">
                        <ul class="space-y-3">
                            <template x-for="item in section.items" :key="item.id">
                                <li class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between rounded-xl border border-rs-border px-4 py-3">
                                    <span class="text-sm text-rs-text-primary" x-text="item.label"></span>
                                    <select
                                        class="rounded-lg border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary min-w-[12rem]"
                                        x-model="item.value"
                                    >
                                        <template x-for="opt in item.options" :key="opt">
                                            <option :value="opt" x-text="opt"></option>
                                        </template>
                                    </select>
                                </li>
                            </template>
                        </ul>
                    </template>

                    <template x-if="section.type === 'checkbox'">
                        <ul class="space-y-3">
                            <template x-for="item in section.items" :key="item.id">
                                <li class="flex items-center justify-between gap-4 rounded-xl border border-rs-border px-4 py-3">
                                    <span class="text-sm text-rs-text-primary" x-text="item.label"></span>
                                    <input
                                        type="checkbox"
                                        class="h-5 w-5 rounded border-rs-border text-rs-primary focus:ring-rs-primary"
                                        :checked="item.checked"
                                        @change="toggleCheckbox(sectionIndex, item.id, $event.target.checked)"
                                    />
                                </li>
                            </template>
                        </ul>
                    </template>
                </div>
            </template>

            <p x-show="message" x-cloak x-text="message" class="text-sm font-medium text-rs-success"></p>

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between pt-4 border-t border-rs-border">
                <button
                    type="button"
                    @click="saveDraft()"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-rs-primary px-5 py-2.5 text-sm font-semibold text-rs-primary hover:bg-rs-primary/5"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                    Simpan Draft
                </button>
                <button
                    type="button"
                    @click="complete()"
                    class="inline-flex items-center justify-center rounded-xl bg-rs-primary px-6 py-2.5 text-sm font-semibold text-white hover:bg-rs-primary-dark"
                >
                    Selesai Checklist
                </button>
            </div>
        </div>
    @else
        @include('apps.surgicare.partials.checklist-tab-panels')
    @endif
</x-surgicare-layout>
