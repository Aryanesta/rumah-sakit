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
        <h2 id="add-patient-title" class="text-lg font-bold text-rs-text-primary mb-4">Tambah Pasien</h2>

        <form method="POST" action="{{ route('apps.angsmart.patients.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-rs-text-primary mb-1">Nama Pasien</label>
                <input id="name" name="name" type="text" required class="w-full rounded-xl border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary" />
            </div>
            <div>
                <label for="medical_record" class="block text-sm font-medium text-rs-text-primary mb-1">No. RM</label>
                <input id="medical_record" name="medical_record" type="text" required class="w-full rounded-xl border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary" />
            </div>
            <div>
                <label for="bed" class="block text-sm font-medium text-rs-text-primary mb-1">Bed</label>
                <input id="bed" name="bed" type="text" required class="w-full rounded-xl border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary" />
            </div>
            <div>
                <label for="diagnosis" class="block text-sm font-medium text-rs-text-primary mb-1">Diagnosis</label>
                <input id="diagnosis" name="diagnosis" type="text" required class="w-full rounded-xl border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary" />
            </div>
            <div>
                <label for="phase" class="block text-sm font-medium text-rs-text-primary mb-1">Fase</label>
                <select id="phase" name="phase" class="w-full rounded-xl border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary">
                    <option value="pre_op">Pre-Op</option>
                    <option value="post_op">Post-Op</option>
                </select>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" @click="open = false" class="rounded-xl border border-rs-border px-4 py-2 text-sm font-semibold">Batal</button>
                <button type="submit" class="rounded-xl bg-rs-primary px-4 py-2 text-sm font-semibold text-white hover:bg-rs-primary-dark">Simpan</button>
            </div>
        </form>
    </div>
</div>
