<div
    x-show="formOpen"
    x-cloak
    @keydown.escape.window="formOpen && closeForm()"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    role="dialog"
    aria-modal="true"
    :aria-labelledby="formMode === 'create' ? 'patient-form-title-create' : 'patient-form-title-edit'"
>
    <div class="absolute inset-0 bg-black/40" @click="closeForm()"></div>

    <div class="relative w-full max-w-lg rounded-2xl bg-rs-surface border border-rs-border shadow-xl p-6 max-h-[90vh] overflow-y-auto">
        <h2
            id="patient-form-title-create"
            x-show="formMode === 'create'"
            class="text-lg font-bold text-rs-text-primary mb-4"
        >
            Tambah Pasien
        </h2>
        <h2
            id="patient-form-title-edit"
            x-show="formMode === 'edit'"
            x-cloak
            class="text-lg font-bold text-rs-text-primary mb-4"
        >
            Ubah Data Pasien
        </h2>

        <form class="space-y-4" @submit.prevent="submitForm()">
            <div>
                <label for="patient_name" class="block text-sm font-medium text-rs-text-primary mb-1">Nama Pasien</label>
                <input
                    id="patient_name"
                    type="text"
                    x-model="form.name"
                    class="w-full rounded-xl border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary"
                />
                <p x-show="formErrors.name" x-text="formErrors.name" class="mt-1 text-xs text-rs-emergency-dark"></p>
            </div>
            <div>
                <label for="patient_medical_record" class="block text-sm font-medium text-rs-text-primary mb-1">No. RM</label>
                <input
                    id="patient_medical_record"
                    type="text"
                    x-model="form.medical_record"
                    class="w-full rounded-xl border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary"
                />
                <p x-show="formErrors.medical_record" x-text="formErrors.medical_record" class="mt-1 text-xs text-rs-emergency-dark"></p>
            </div>
            <div>
                <label for="patient_room_bed" class="block text-sm font-medium text-rs-text-primary mb-1">Kamar</label>
                <input
                    id="patient_room_bed"
                    type="text"
                    x-model="form.room_bed"
                    placeholder="Contoh: Angsoka 1 / 102"
                    class="w-full rounded-xl border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary"
                />
                <p x-show="formErrors.room_bed" x-text="formErrors.room_bed" class="mt-1 text-xs text-rs-emergency-dark"></p>
            </div>
            <div>
                <label for="patient_date_of_birth" class="block text-sm font-medium text-rs-text-primary mb-1">Tanggal Lahir</label>
                <input
                    id="patient_date_of_birth"
                    type="date"
                    x-model="form.date_of_birth"
                    class="w-full rounded-xl border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary"
                />
                <p x-show="formErrors.date_of_birth" x-text="formErrors.date_of_birth" class="mt-1 text-xs text-rs-emergency-dark"></p>
            </div>
            <div>
                <label for="patient_gender" class="block text-sm font-medium text-rs-text-primary mb-1">Gender</label>
                <select
                    id="patient_gender"
                    x-model="form.gender"
                    class="w-full rounded-xl border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary"
                >
                    <template x-for="option in genderOptions" :key="option.value">
                        <option :value="option.value" x-text="option.label"></option>
                    </template>
                </select>
                <p x-show="formErrors.gender" x-text="formErrors.gender" class="mt-1 text-xs text-rs-emergency-dark"></p>
            </div>
            <div>
                <label for="patient_phase_status" class="block text-sm font-medium text-rs-text-primary mb-1">Status Fase</label>
                <select
                    id="patient_phase_status"
                    x-model="form.phase_status"
                    class="w-full rounded-xl border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary"
                >
                    <template x-for="option in phaseOptions" :key="option.value">
                        <option :value="option.value" x-text="option.label"></option>
                    </template>
                </select>
                <p x-show="formErrors.phase_status" x-text="formErrors.phase_status" class="mt-1 text-xs text-rs-emergency-dark"></p>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button
                    type="button"
                    @click="closeForm()"
                    class="rounded-xl border border-rs-border px-4 py-2 text-sm font-semibold"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="rounded-xl bg-rs-primary px-4 py-2 text-sm font-semibold text-white hover:bg-rs-primary-dark"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
