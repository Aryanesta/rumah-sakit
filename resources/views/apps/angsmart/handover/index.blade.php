<x-angsmart-layout breadcrumb="Beranda › Handover">
    <x-angsmart.page-header title="Handover" />

    @php
        $tabs = [
            'handover' => [
                'label' => 'Handover Antar Shift',
                'href' => route('apps.angsmart.handover.index', ['tab' => 'handover']),
            ],
            'history' => [
                'label' => 'Riwayat Handover',
                'href' => route('apps.angsmart.handover.index', ['tab' => 'history']),
            ],
        ];
    @endphp

    <x-angsmart.tabs :tabs="$tabs" :active="$activeTab" />

    @if ($activeTab === 'history')
        <div class="bg-rs-surface border border-rs-border rounded-2xl shadow-sm overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-rs-background text-rs-text-secondary">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Pasien</th>
                        <th class="px-4 py-3 text-left font-semibold">Shift</th>
                        <th class="px-4 py-3 text-left font-semibold">Perawat</th>
                        <th class="px-4 py-3 text-left font-semibold">Dikunci</th>
                        <th class="px-4 py-3 text-left font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-rs-border">
                    @foreach ($handoverHistory as $entry)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $entry['patient_name'] }}</td>
                            <td class="px-4 py-3">{{ $entry['shift'] }}</td>
                            <td class="px-4 py-3">{{ $entry['nurse'] }}</td>
                            <td class="px-4 py-3">{{ $entry['locked_at'] }}</td>
                            <td class="px-4 py-3">
                                <x-angsmart.status-badge :label="$entry['status']->label()" tone="success" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div
            x-data="angsmartHandover(@js($handoverDetails), @js($defaultPatientSlug))"
            class="bg-rs-surface border border-rs-border rounded-2xl p-6 shadow-sm space-y-6"
        >
            <div>
                <label for="patient_select" class="block text-sm font-semibold text-rs-text-primary mb-2">Pilih Pasien</label>
                <select
                    id="patient_select"
                    x-model="selectedSlug"
                    class="w-full rounded-xl border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary"
                >
                    @foreach ($patients as $patient)
                        <option value="{{ $patient['slug'] }}">
                            {{ $patient['name'] }} (No. RM {{ $patient['medical_record'] }}) — Bed {{ $patient['bed'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <div class="space-y-6">
                    <div>
                        <h3 class="font-semibold text-rs-text-primary mb-3">Informasi Pasien</h3>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                            <div><dt class="text-rs-text-secondary">Diagnosis</dt><dd class="font-medium" x-text="detail.diagnosis"></dd></div>
                            <div><dt class="text-rs-text-secondary">Tindakan</dt><dd class="font-medium" x-text="detail.procedure"></dd></div>
                            <div><dt class="text-rs-text-secondary">Fase</dt><dd class="font-medium" x-text="detail.phase"></dd></div>
                            <div><dt class="text-rs-text-secondary">DPJP</dt><dd class="font-medium" x-text="detail.dpjp"></dd></div>
                            <div class="sm:col-span-2"><dt class="text-rs-text-secondary">Alergi</dt><dd class="font-medium" x-text="detail.allergy"></dd></div>
                        </dl>
                    </div>

                    <div>
                        <h3 class="font-semibold text-rs-text-primary mb-3">Rangkuman Asuhan</h3>
                        <ul class="space-y-2 text-sm">
                            <template x-for="(line, index) in detail.summary" :key="index">
                                <li class="flex items-start gap-2">
                                    <span class="text-rs-success mt-0.5" aria-hidden="true">✓</span>
                                    <span x-text="line"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="handover_message" class="block text-sm font-semibold mb-2">Pesan Handover</label>
                        <textarea
                            id="handover_message"
                            rows="6"
                            x-model="message"
                            placeholder="Tambahkan catatan untuk shift berikutnya..."
                            class="w-full rounded-xl border-rs-border text-sm"
                        ></textarea>
                    </div>

                    <div>
                        <p class="text-sm font-semibold mb-2">Lampiran (opsional)</p>
                        <div class="space-y-2 text-sm">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" x-model="attachments.plan" class="rounded border-rs-border text-rs-primary focus:ring-rs-primary" />
                                Rencana Keperawatan
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" x-model="attachments.exam" class="rounded border-rs-border text-rs-primary focus:ring-rs-primary" />
                                Laporan Pemeriksaan
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" x-model="attachments.photo" class="rounded border-rs-border text-rs-primary focus:ring-rs-primary" />
                                Foto Luka/Drain
                            </label>
                        </div>
                        <button type="button" class="mt-3 rounded-xl border border-rs-border px-4 py-2 text-sm font-semibold">Pilih File</button>
                    </div>

                    <p x-show="submitted" x-cloak class="text-sm text-rs-success font-medium">Handover terkirim (mode demo).</p>

                    <div class="flex flex-wrap gap-3 justify-end pt-2">
                        <button
                            type="button"
                            @click="finalize()"
                            class="rounded-xl border border-rs-border px-4 py-2.5 text-sm font-semibold hover:bg-rs-background"
                        >
                            Kunci / Finalisasi
                        </button>
                        <button
                            type="button"
                            @click="submit()"
                            class="inline-flex items-center gap-2 rounded-xl bg-rs-primary-dark px-5 py-2.5 text-sm font-semibold text-white hover:bg-rs-primary"
                        >
                            Kirim Handover
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-angsmart-layout>
