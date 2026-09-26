<div
    x-show="deleteOpen"
    x-cloak
    @keydown.escape.window="deleteOpen && closeDeleteConfirm()"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="delete-patient-title"
>
    <div class="absolute inset-0 bg-black/40" @click="closeDeleteConfirm()"></div>

    <div class="relative w-full max-w-md rounded-2xl bg-rs-surface border border-rs-border shadow-xl p-6">
        <h2 id="delete-patient-title" class="text-lg font-bold text-rs-text-primary mb-2">Hapus data pasien?</h2>
        <p class="text-sm text-rs-text-secondary mb-6">
            Pasien
            <span class="font-semibold text-rs-text-primary" x-text="patientToDelete?.name"></span>
            (No. RM
            <span class="font-semibold" x-text="patientToDelete?.medical_record"></span>)
            akan dihapus dari daftar. Tindakan ini tidak dapat dibatalkan pada sesi demo ini.
        </p>

        <div class="flex justify-end gap-2">
            <button
                type="button"
                @click="closeDeleteConfirm()"
                class="rounded-xl border border-rs-border px-4 py-2 text-sm font-semibold"
            >
                Batal
            </button>
            <button
                type="button"
                @click="confirmDelete()"
                class="rounded-xl bg-rs-emergency px-4 py-2 text-sm font-semibold text-white hover:opacity-90"
            >
                Ya, hapus
            </button>
        </div>
    </div>
</div>
