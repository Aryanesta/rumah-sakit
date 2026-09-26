<x-ansafe-layout breadcrumb="Beranda › Asesmen Risiko Jatuh">
    <x-ansafe.patient-header-card :patient="$patient" class="mb-6" />

    <x-ansafe.page-header
        title="Morse Fall Scale"
        subtitle="Pilih jawaban yang sesuai dengan kondisi pasien. Sistem akan menghitung skor secara otomatis."
    />

    <div
        x-data="ansafeMfsForm(@js($dimensions), @js($selections))"
        class="space-y-6"
    >
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <template x-for="dimension in dimensions" :key="dimension.key">
                <fieldset class="bg-rs-surface border border-rs-border rounded-2xl p-5 shadow-sm">
                    <legend class="text-sm font-semibold text-rs-text-primary mb-3" x-text="dimension.label"></legend>
                    <div class="space-y-2">
                        <template x-for="option in dimension.options" :key="option.value">
                            <label class="flex items-center gap-3 rounded-xl border border-rs-border px-3 py-2.5 cursor-pointer hover:bg-rs-background transition-colors has-[:checked]:border-rs-primary has-[:checked]:bg-rs-primary-light/20">
                                <input
                                    type="radio"
                                    class="text-rs-primary focus:ring-rs-primary"
                                    :name="dimension.key"
                                    :value="option.value"
                                    x-model="selections[dimension.key]"
                                />
                                <span class="text-sm text-rs-text-primary" x-text="option.label"></span>
                            </label>
                        </template>
                    </div>
                </fieldset>
            </template>
        </div>

        <div class="bg-rs-surface border border-rs-border rounded-2xl p-5 sm:p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-wrap items-center gap-4">
                    <div class="rounded-xl border-2 border-rs-primary px-6 py-3 text-center min-w-[120px]">
                        <p class="text-xs text-rs-text-secondary">Total Skor</p>
                        <p class="text-3xl font-bold text-rs-primary-dark tabular-nums" x-text="total()"></p>
                    </div>
                    <div>
                        <p class="text-xs text-rs-text-secondary mb-1">Kategori Risiko</p>
                        <span
                            class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-bold"
                            :class="{
                                'bg-rs-success/20 text-rs-accent-dark': category() === 'rendah',
                                'bg-rs-warning/20 text-rs-warning': category() === 'sedang',
                                'bg-rs-emergency text-white': category() === 'tinggi',
                            }"
                            x-text="categoryLabel()"
                        ></span>
                    </div>
                </div>

                <p
                    class="flex-1 rounded-xl px-4 py-3 text-sm leading-relaxed"
                    :class="category() === 'tinggi' ? 'bg-rs-emergency-light text-rs-emergency-dark' : 'bg-rs-background text-rs-text-secondary'"
                    x-text="protocolMessage()"
                ></p>
            </div>
        </div>

        <p x-show="demoMessage" x-text="demoMessage" class="text-sm text-rs-primary-dark bg-rs-primary-light/30 border border-rs-primary/20 rounded-xl px-4 py-3"></p>

        <div class="flex flex-wrap gap-3 justify-end">
            <button
                type="button"
                @click="showDemoSave()"
                class="rounded-xl border border-rs-border bg-rs-surface px-5 py-2.5 text-sm font-semibold text-rs-text-primary hover:bg-rs-background transition-colors"
            >
                Simpan Draft
            </button>
            <button
                type="button"
                @click="showDemoSave()"
                class="rounded-xl bg-rs-primary px-5 py-2.5 text-sm font-semibold text-white hover:bg-rs-primary-dark transition-colors"
            >
                Simpan &amp; Lanjutkan
            </button>
        </div>
    </div>
</x-ansafe-layout>
