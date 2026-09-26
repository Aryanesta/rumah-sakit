<div class="bg-rs-surface border border-rs-border rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-rs-background text-rs-text-secondary">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">No</th>
                    <th class="px-4 py-3 text-left font-semibold">Nama Pasien</th>
                    <th class="px-4 py-3 text-left font-semibold">No. RM</th>
                    <th class="px-4 py-3 text-left font-semibold">Kamar</th>
                    <th class="px-4 py-3 text-left font-semibold">Tanggal Lahir</th>
                    <th class="px-4 py-3 text-left font-semibold">Gender</th>
                    <th class="px-4 py-3 text-left font-semibold">Status Fase</th>
                    <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-rs-border">
                <template x-if="paginatedPatients().length === 0">
                    <tr>
                        <td colspan="8" class="px-4 py-10 text-center text-rs-text-secondary">
                            Tidak ada data pasien.
                        </td>
                    </tr>
                </template>
                <template x-for="(patient, index) in paginatedPatients()" :key="patient.id">
                    <tr class="hover:bg-rs-background/80">
                        <td class="px-4 py-3 text-rs-text-secondary" x-text="rowNumber(index)"></td>
                        <td class="px-4 py-3 font-medium text-rs-text-primary" x-text="patient.name"></td>
                        <td class="px-4 py-3" x-text="patient.medical_record"></td>
                        <td class="px-4 py-3" x-text="patient.room_bed"></td>
                        <td class="px-4 py-3" x-text="displayDateOfBirth(patient.date_of_birth)"></td>
                        <td class="px-4 py-3" x-text="displayGender(patient.gender)"></td>
                        <td class="px-4 py-3">
                            <span
                                class="inline-flex rounded-full border px-2.5 py-0.5 text-xs font-semibold"
                                :class="phaseBadgeClass(patient.phase_status)"
                                x-text="displayPhase(patient.phase_status)"
                            ></span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <button
                                    type="button"
                                    class="rounded-lg border border-rs-primary px-3 py-1.5 text-xs font-semibold text-rs-primary hover:bg-rs-primary/5"
                                    @click="openEditForm(patient)"
                                >
                                    Edit
                                </button>
                                <button
                                    type="button"
                                    class="rounded-lg border border-rs-emergency/40 px-3 py-1.5 text-xs font-semibold text-rs-emergency-dark hover:bg-rs-emergency-light/50"
                                    @click="openDeleteConfirm(patient)"
                                >
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between px-4 py-3 border-t border-rs-border text-sm text-rs-text-secondary">
        <p x-text="paginationSummary()"></p>
        <div class="flex items-center gap-2">
            <button
                type="button"
                class="rounded-lg border border-rs-border px-3 py-1 disabled:opacity-40"
                :disabled="page === 1"
                @click="page--"
            >&lsaquo;</button>
            <template x-for="p in totalPages()" :key="p">
                <button
                    type="button"
                    class="rounded-lg px-3 py-1 font-semibold"
                    :class="p === page ? 'bg-rs-primary text-white' : 'border border-rs-border text-rs-text-primary'"
                    @click="page = p"
                    x-text="p"
                ></button>
            </template>
            <button
                type="button"
                class="rounded-lg border border-rs-border px-3 py-1 disabled:opacity-40"
                :disabled="page === totalPages().length"
                @click="page++"
            >&rsaquo;</button>
        </div>
    </div>
</div>
