<div class="bg-rs-surface border border-rs-border rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-rs-background text-rs-text-secondary">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">No</th>
                    <th class="px-4 py-3 text-left font-semibold">Nama Pasien</th>
                    <th class="px-4 py-3 text-left font-semibold">No. RM</th>
                    <th class="px-4 py-3 text-left font-semibold">Bed</th>
                    <th class="px-4 py-3 text-left font-semibold">Usia</th>
                    <th class="px-4 py-3 text-left font-semibold">Diagnosis</th>
                    <th class="px-4 py-3 text-left font-semibold">Fase</th>
                    <th class="px-4 py-3 text-left font-semibold">Status Asuhan</th>
                    <th class="px-4 py-3 text-left font-semibold">Risiko Jatuh</th>
                    <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-rs-border">
                <template x-for="(patient, index) in paginatedPatients()" :key="patient.slug">
                    <tr class="hover:bg-rs-background/80">
                        <td class="px-4 py-3 text-rs-text-secondary" x-text="rowNumber(index)"></td>
                        <td class="px-4 py-3 font-medium text-rs-text-primary" x-text="patient.name"></td>
                        <td class="px-4 py-3" x-text="patient.medical_record"></td>
                        <td class="px-4 py-3" x-text="patient.bed"></td>
                        <td class="px-4 py-3" x-text="patient.age + ' th'"></td>
                        <td class="px-4 py-3" x-text="patient.diagnosis"></td>
                        <td class="px-4 py-3">
                            <span
                                class="inline-flex rounded-full border px-2.5 py-0.5 text-xs font-semibold"
                                :class="patient.phase === 'pre_op' ? 'bg-rs-primary-light/40 text-rs-primary-dark border-rs-primary/30' : 'bg-purple-100 text-purple-800 border-purple-200'"
                                x-text="patient.phase === 'pre_op' ? 'Pre-Op' : 'Post-Op'"
                            ></span>
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="inline-flex rounded-full border px-2.5 py-0.5 text-xs font-semibold"
                                :class="patient.care_status === 'dalam_asuhan' ? 'bg-rs-success/20 text-rs-accent-dark border-rs-success/40' : 'bg-rs-warning/20 text-rs-warning border-rs-warning/40'"
                                x-text="patient.care_status === 'dalam_asuhan' ? 'Dalam Asuhan' : 'Menunggu Tindakan'"
                            ></span>
                        </td>
                        <td class="px-4 py-3">
                            <template x-if="patient.fall_risk">
                                <span
                                    class="inline-flex rounded-full border px-2.5 py-0.5 text-xs font-semibold capitalize"
                                    :class="{
                                        'bg-rs-success/20 text-rs-accent-dark border-rs-success/40': patient.fall_risk === 'rendah',
                                        'bg-rs-warning/20 text-rs-warning border-rs-warning/40': patient.fall_risk === 'sedang',
                                        'bg-rs-emergency-light text-rs-emergency-dark border-rs-emergency/30': patient.fall_risk === 'tinggi',
                                    }"
                                    x-text="patient.fall_risk"
                                ></span>
                            </template>
                            <template x-if="!patient.fall_risk">
                                <span class="text-rs-text-secondary">—</span>
                            </template>
                        </td>
                        <td class="px-4 py-3">
                            <a
                                class="text-rs-primary font-semibold hover:text-rs-primary-dark"
                                :href="`{{ url('/apps/angsmart/patients') }}/${patient.slug}/nursing-care`"
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
        </div>
    </div>
</div>
