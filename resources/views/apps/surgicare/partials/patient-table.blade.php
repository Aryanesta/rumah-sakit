<div class="bg-rs-surface border border-rs-border rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-rs-background text-rs-text-secondary">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">No</th>
                    <th class="px-4 py-3 text-left font-semibold">Nama Pasien</th>
                    <th class="px-4 py-3 text-left font-semibold">No. RM</th>
                    <th class="px-4 py-3 text-left font-semibold">Umur</th>
                    <th class="px-4 py-3 text-left font-semibold">Diagnosa</th>
                    <th class="px-4 py-3 text-left font-semibold">Jenis Tindakan</th>
                    <th class="px-4 py-3 text-left font-semibold">Fase</th>
                    <th class="px-4 py-3 text-left font-semibold">Status</th>
                    <th class="px-4 py-3 text-left font-semibold">Status Guide</th>
                    <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-rs-border">
                <template x-for="(patient, index) in paginatedPatients()" :key="patient.slug">
                    <tr class="hover:bg-rs-background/80">
                        <td class="px-4 py-3 text-rs-text-secondary" x-text="rowNumber(index)"></td>
                        <td class="px-4 py-3 font-medium text-rs-text-primary" x-text="patient.name"></td>
                        <td class="px-4 py-3" x-text="patient.medical_record"></td>
                        <td class="px-4 py-3" x-text="patient.age + ' Th'"></td>
                        <td class="px-4 py-3" x-text="patient.diagnosis"></td>
                        <td class="px-4 py-3" x-text="patient.procedure"></td>
                        <td class="px-4 py-3">
                            <span
                                class="inline-flex rounded-full border px-2.5 py-0.5 text-xs font-semibold"
                                :class="patient.phase === 'pre_op' ? 'bg-amber-100 text-amber-900 border-amber-200' : 'bg-rs-primary-light/40 text-rs-primary-dark border-rs-primary/30'"
                                x-text="patient.phase === 'pre_op' ? 'Pre-Op' : 'Post-Op'"
                            ></span>
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="inline-flex rounded-full border px-2.5 py-0.5 text-xs font-semibold"
                                :class="statusBadgeClass(patient.checklist_status_tone)"
                                x-text="patient.checklist_status"
                            ></span>
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="inline-flex rounded-full border px-2.5 py-0.5 text-xs font-semibold"
                                :class="statusBadgeClass(patient.guide_status_tone)"
                                x-text="patient.guide_status"
                            ></span>
                            <template x-if="patient.guide_warning">
                                <span
                                    class="ml-1 inline-flex rounded-full border px-2 py-0.5 text-xs font-semibold"
                                    :class="patient.guide_warning === 'red' ? 'bg-rs-emergency-light text-rs-emergency-dark border-rs-emergency/30' : 'bg-rs-warning/20 text-rs-warning border-rs-warning/40'"
                                    x-text="patient.guide_warning === 'red' ? '!' : '?'"
                                ></span>
                            </template>
                        </td>
                        <td class="px-4 py-3">
                            <a
                                class="inline-flex rounded-lg border border-rs-primary px-3 py-1.5 text-xs font-semibold text-rs-primary hover:bg-rs-primary/5"
                                :href="checklistUrl(patient)"
                            >Detail</a>
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
            <button
                type="button"
                class="rounded-lg border border-rs-border px-2 py-1 disabled:opacity-40"
                :disabled="page === totalPages().length"
                @click="page = totalPages().length"
                title="Halaman terakhir"
            >&raquo;</button>
        </div>
    </div>
</div>
