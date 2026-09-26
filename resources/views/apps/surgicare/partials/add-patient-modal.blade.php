<div
    x-data="{ open: false }"
    @open-add-patient-modal.window="open = true"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="add-patient-title"
>
    <div class="absolute inset-0 bg-black/40" @click="open = false"></div>

    <div class="relative w-full max-w-lg rounded-2xl bg-rs-surface border border-rs-border shadow-xl p-6">
        <h2 id="add-patient-title" class="text-lg font-bold text-rs-text-primary mb-2">Tambah Pasien</h2>
        <p class="text-sm text-rs-text-secondary mb-4">Mode demo — formulir belum tersambung ke database.</p>

        <form class="space-y-4" @submit.prevent="open = false">
            <div>
                <label for="surgicare_name" class="block text-sm font-medium text-rs-text-primary mb-1">Nama Pasien</label>
                <input id="surgicare_name" type="text" class="w-full rounded-xl border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary" />
            </div>
            <div>
                <label for="surgicare_rm" class="block text-sm font-medium text-rs-text-primary mb-1">No. RM</label>
                <input id="surgicare_rm" type="text" class="w-full rounded-xl border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary" />
            </div>
            <div>
                <label for="surgicare_diagnosis" class="block text-sm font-medium text-rs-text-primary mb-1">Diagnosa</label>
                <input id="surgicare_diagnosis" type="text" class="w-full rounded-xl border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary" />
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" @click="open = false" class="rounded-xl border border-rs-border px-4 py-2 text-sm font-semibold">Batal</button>
                <button type="submit" class="rounded-xl bg-rs-primary px-4 py-2 text-sm font-semibold text-white hover:bg-rs-primary-dark">Simpan (Demo)</button>
            </div>
        </form>
    </div>
</div>
