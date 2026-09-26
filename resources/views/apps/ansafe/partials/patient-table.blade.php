<div
    x-data="ansafePatientTable(@js($patients))"
    class="space-y-4"
>
    @include('apps.ansafe.partials.patient-filters', ['roomOptions' => $roomOptions])

    <div class="bg-rs-surface border border-rs-border rounded-2xl shadow-sm overflow-hidden ansafe-surface">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-rs-background text-rs-text-secondary">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">No</th>
                        <th class="px-4 py-3 text-left font-semibold">Nama Pasien</th>
                        <th class="px-4 py-3 text-left font-semibold">No. RM</th>
                        <th class="px-4 py-3 text-left font-semibold">Usia</th>
                        <th class="px-4 py-3 text-left font-semibold">Kamar/Bed</th>
                        <th class="px-4 py-3 text-left font-semibold">Diagnosis</th>
                        <th class="px-4 py-3 text-left font-semibold">Risiko Jatuh</th>
                        <th class="px-4 py-3 text-left font-semibold">Assessment Terakhir</th>
                        <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-rs-border">
                    <template x-for="(patient, index) in filteredPatients()" :key="patient.slug">
                        <tr class="hover:bg-rs-background/80">
                            <td class="px-4 py-3 text-rs-text-secondary" x-text="index + 1"></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-100 text-amber-800 text-xs font-bold" x-text="patient.name.charAt(0)"></span>
                                    <span class="font-medium text-rs-text-primary" x-text="patient.name"></span>
                                </div>
                            </td>
                            <td class="px-4 py-3" x-text="patient.medical_record"></td>
                            <td class="px-4 py-3" x-text="patient.age + ' th'"></td>
                            <td class="px-4 py-3" x-text="patient.room + ' / ' + patient.bed"></td>
                            <td class="px-4 py-3" x-text="patient.diagnosis"></td>
                            <td class="px-4 py-3">
                                <span
                                    class="inline-flex rounded-full border px-2.5 py-0.5 text-xs font-semibold"
                                    :class="{
                                        'bg-rs-success/20 text-emerald-800 border-rs-success/40': patient.risk === 'rendah',
                                        'bg-rs-warning/20 text-rs-warning border-rs-warning/40': patient.risk === 'sedang',
                                        'bg-rs-emergency-light text-rs-emergency-dark border-rs-emergency/30': patient.risk === 'tinggi',
                                    }"
                                    x-text="patient.risk === 'tinggi' ? 'Tinggi' : (patient.risk === 'sedang' ? 'Sedang' : 'Rendah')"
                                ></span>
                            </td>
                            <td class="px-4 py-3 text-rs-text-secondary" x-text="patient.last_assessment_at"></td>
                            <td class="px-4 py-3">
                                <a
                                    class="inline-flex rounded-lg bg-amber-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-amber-700 transition-colors"
                                    :href="`{{ url('/apps/ansafe/patients') }}/${patient.slug}/assessment`"
                                >Lihat</a>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
