<x-angsmart-layout pageTitle="Laporan">
    <x-angsmart.page-header title="Laporan &amp; Monitoring" class="animate-element animate-delay-100" />

    @php
        $tabs = [
            'laporan' => [
                'label' => 'Laporan',
                'href' => route('apps.angsmart.reports.index', ['tab' => 'laporan']),
            ],
            'monitoring' => [
                'label' => 'Monitoring Berkala',
                'href' => route('apps.angsmart.reports.index', ['tab' => 'monitoring']),
            ],
        ];
    @endphp

    <x-angsmart.tabs :tabs="$tabs" :active="$activeTab" />

    @if ($activeTab === 'monitoring')
        <div class="bg-rs-surface border border-rs-border rounded-2xl shadow-sm overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-rs-background text-rs-text-secondary">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Waktu</th>
                        <th class="px-4 py-3 text-left font-semibold">Tugas</th>
                        <th class="px-4 py-3 text-left font-semibold">Pasien</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-rs-border">
                    @foreach ($monitoring as $row)
                        <tr>
                            <td class="px-4 py-3">{{ $row['time'] }}</td>
                            <td class="px-4 py-3">{{ $row['task'] }}</td>
                            <td class="px-4 py-3">{{ $row['patient'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div x-data="angsmartReportFilters(@js($detailRows))" class="space-y-6">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-end">
                <div>
                    <label for="period" class="block text-sm font-medium mb-1">Periode</label>
                    <select id="period" x-model="period" class="rounded-xl border-rs-border text-sm">
                        <option value="today">Hari ini</option>
                        <option value="week">Minggu ini</option>
                        <option value="month">Bulan ini</option>
                    </select>
                </div>
                <div>
                    <label for="report_shift" class="block text-sm font-medium mb-1">Shift</label>
                    <select id="report_shift" x-model="shift" class="rounded-xl border-rs-border text-sm">
                        <option value="pagi">Pagi</option>
                        <option value="siang">Siang</option>
                        <option value="malam">Malam</option>
                    </select>
                </div>
                <button
                    type="button"
                    @click="generate()"
                    class="rounded-xl bg-rs-primary-dark px-6 py-2.5 text-sm font-semibold text-white hover:bg-rs-primary"
                >
                    Generate Laporan
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                <x-angsmart.stat-card label="Total Pasien" :value="$summary['total']" tone="primary" />
                <x-angsmart.stat-card label="Tindakan Selesai" :value="$summary['completed']" tone="success" />
                <x-angsmart.stat-card label="Tindakan Belum" :value="$summary['pending']" tone="emergency" />
                <x-angsmart.stat-card label="Jatuh / Insiden" :value="$summary['incidents']" tone="emergency" />
            </div>

            <div class="bg-rs-surface border border-rs-border rounded-2xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-rs-border">
                    <h3 class="font-semibold">Detail Laporan</h3>
                    <p x-show="generated" x-cloak class="text-xs text-rs-text-secondary mt-1">Laporan diperbarui (mode demo).</p>
                </div>
                <table class="min-w-full text-sm">
                    <thead class="bg-rs-background text-rs-text-secondary">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">No</th>
                            <th class="px-4 py-3 text-left font-semibold">Nama Pasien</th>
                            <th class="px-4 py-3 text-left font-semibold">No. RM</th>
                            <th class="px-4 py-3 text-left font-semibold">Diagnosa</th>
                            <th class="px-4 py-3 text-left font-semibold">Diagnosa Keperawatan</th>
                            <th class="px-4 py-3 text-left font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-rs-border">
                        <template x-for="(row, index) in visibleRows" :key="row.medical_record">
                            <tr>
                                <td class="px-4 py-3" x-text="index + 1"></td>
                                <td class="px-4 py-3 font-medium" x-text="row.name"></td>
                                <td class="px-4 py-3" x-text="row.medical_record"></td>
                                <td class="px-4 py-3" x-text="row.diagnosis"></td>
                                <td class="px-4 py-3" x-text="row.nursing_diagnosis"></td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex rounded-full border px-2.5 py-0.5 text-xs font-semibold"
                                        :class="row.status === 'selesai' ? 'bg-rs-success/20 text-rs-accent-dark border-rs-success/40' : 'bg-rs-warning/20 text-rs-warning border-rs-warning/40'"
                                        x-text="row.status === 'selesai' ? 'Selesai' : 'Dalam Proses'"
                                    ></span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" class="inline-flex items-center gap-2 rounded-xl border border-rs-border px-4 py-2 text-sm font-semibold" disabled aria-disabled="true">
                    Cetak
                </button>
                <button type="button" class="inline-flex items-center gap-2 rounded-xl border border-rs-border px-4 py-2 text-sm font-semibold" disabled aria-disabled="true">
                    Export PDF
                </button>
            </div>
        </div>
    @endif
</x-angsmart-layout>
