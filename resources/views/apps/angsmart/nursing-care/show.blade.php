<x-angsmart-layout breadcrumb="Beranda › Asuhan Keperawatan">
    <x-angsmart.page-header title="Asuhan Keperawatan" />

    <x-angsmart.patient-header-card :patient="$patient" class="mb-6" />

    @php
        $patientSlug = $patient['slug'];
        $tabs = [
            'input' => [
                'label' => 'Input Asuhan',
                'href' => route('apps.angsmart.patients.nursing-care', $patientSlug).'?tab=input',
            ],
            'monitoring' => [
                'label' => 'Monitoring',
                'href' => route('apps.angsmart.patients.nursing-care', $patientSlug).'?tab=monitoring',
            ],
            'history' => [
                'label' => 'Riwayat',
                'href' => route('apps.angsmart.patients.nursing-care', $patientSlug).'?tab=history',
            ],
        ];
    @endphp

    <x-angsmart.tabs :tabs="$tabs" :active="$activeTab" />

    @if ($activeTab === 'input')
        <div
            x-data="angsmartNursingCareForm(@js($actionTypes))"
            class="grid grid-cols-1 xl:grid-cols-2 gap-6"
        >
            <div class="bg-rs-surface border border-rs-border rounded-2xl p-6 shadow-sm">
                <h3 class="font-semibold text-rs-text-primary mb-4">Input Tindakan Keperawatan</h3>
                <form class="space-y-4" @submit.prevent="save()">
                    <div>
                        <label for="action_type" class="block text-sm font-medium mb-1">Jenis Tindakan</label>
                        <select id="action_type" x-model="actionType" class="w-full rounded-xl border-rs-border text-sm">
                            <template x-for="type in actionTypes" :key="type">
                                <option :value="type" x-text="type"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label for="action_date" class="block text-sm font-medium mb-1">Tanggal</label>
                        <input id="action_date" type="date" x-model="actionDate" class="w-full rounded-xl border-rs-border text-sm" />
                    </div>
                    <div>
                        <label for="shift" class="block text-sm font-medium mb-1">Shift</label>
                        <select id="shift" x-model="shift" class="w-full rounded-xl border-rs-border text-sm">
                            <option value="pagi">Pagi</option>
                            <option value="siang">Siang</option>
                            <option value="malam">Malam</option>
                        </select>
                    </div>
                    <div>
                        <p class="block text-sm font-medium mb-2">Status</p>
                        <div class="flex flex-wrap gap-4 text-sm">
                            <label class="inline-flex items-center gap-2">
                                <input type="radio" value="selesai" x-model="status" class="text-rs-primary focus:ring-rs-primary" />
                                Selesai
                            </label>
                            <label class="inline-flex items-center gap-2">
                                <input type="radio" value="dalam_proses" x-model="status" class="text-rs-primary focus:ring-rs-primary" />
                                Dalam Proses
                            </label>
                            <label class="inline-flex items-center gap-2">
                                <input type="radio" value="belum" x-model="status" class="text-rs-primary focus:ring-rs-primary" />
                                Belum
                            </label>
                        </div>
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-medium mb-1">Catatan</label>
                        <textarea id="notes" rows="4" x-model="notes" placeholder="Masukkan catatan tindakan keperawatan..." class="w-full rounded-xl border-rs-border text-sm"></textarea>
                    </div>
                    <p x-show="saved" x-cloak class="text-sm text-rs-success font-medium">Tindakan tersimpan (mode demo).</p>
                    <button type="submit" class="w-full rounded-xl bg-rs-primary py-3 text-sm font-semibold text-white hover:bg-rs-primary-dark">
                        Simpan
                    </button>
                </form>
            </div>

            <div class="bg-rs-surface border border-rs-border rounded-2xl p-6 shadow-sm">
                <h3 class="font-semibold text-rs-text-primary mb-4">Daftar Tindakan</h3>
                <ul class="space-y-3">
                    @foreach ($actions as $action)
                        <li class="flex items-center justify-between gap-3 rounded-xl border border-rs-border px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if ($action['status']->value === 'selesai')
                                    <span class="text-rs-success" aria-hidden="true">✓</span>
                                @elseif ($action['status']->value === 'belum')
                                    <span class="text-rs-emergency" aria-hidden="true">✕</span>
                                @else
                                    <span class="text-rs-warning" aria-hidden="true">−</span>
                                @endif
                                <span class="text-sm font-medium">{{ $action['name'] }}</span>
                            </div>
                            <x-angsmart.status-badge :label="$action['status']->label()" :tone="$action['status']->badgeTone()" />
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @elseif ($activeTab === 'monitoring')
        <div class="bg-rs-surface border border-rs-border rounded-2xl p-6 shadow-sm">
            <h3 class="font-semibold text-rs-text-primary mb-4">Monitoring Tindakan</h3>
            <table class="min-w-full text-sm">
                <thead class="text-rs-text-secondary">
                    <tr>
                        <th class="py-2 text-left font-semibold">Waktu</th>
                        <th class="py-2 text-left font-semibold">Tindakan</th>
                        <th class="py-2 text-left font-semibold">Shift</th>
                        <th class="py-2 text-left font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-rs-border">
                    <tr>
                        <td class="py-3">23 Sep 2026 08:00</td>
                        <td class="py-3">Observasi TTV</td>
                        <td class="py-3">Pagi</td>
                        <td class="py-3"><x-angsmart.status-badge label="Selesai" tone="success" /></td>
                    </tr>
                    <tr>
                        <td class="py-3">23 Sep 2026 10:30</td>
                        <td class="py-3">Mobilisasi dini</td>
                        <td class="py-3">Pagi</td>
                        <td class="py-3"><x-angsmart.status-badge label="Dalam Proses" tone="warning" /></td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <div class="bg-rs-surface border border-rs-border rounded-2xl p-6 shadow-sm">
            <h3 class="font-semibold text-rs-text-primary mb-4">Riwayat Asuhan</h3>
            <ul class="space-y-4 text-sm">
                <li class="border-l-2 border-rs-primary pl-4">
                    <p class="font-semibold">Mobilisasi dini — Selesai</p>
                    <p class="text-rs-text-secondary">22 Sep 2026 · Shift Malam · Ns. Rina Wulandari</p>
                </li>
                <li class="border-l-2 border-rs-primary pl-4">
                    <p class="font-semibold">Observasi TTV — Selesai</p>
                    <p class="text-rs-text-secondary">22 Sep 2026 · Shift Siang · Ns. Made Suryani</p>
                </li>
            </ul>
        </div>
    @endif
</x-angsmart-layout>
