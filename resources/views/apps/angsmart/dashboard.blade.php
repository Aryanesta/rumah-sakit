<x-angsmart-layout breadcrumb="Beranda › Dashboard Angsmart">
    <x-angsmart.page-header
        title="ANGSMART (Ringkasan &amp; Akses Cepat)"
        subtitle="Pantau status asuhan keperawatan dan akses fitur utama dengan cepat."
    />

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">
        <x-angsmart.stat-card label="Total Pasien" :value="$stats['total']" tone="primary">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </x-slot:icon>
        </x-angsmart.stat-card>
        <x-angsmart.stat-card label="Dalam Asuhan" :value="$stats['dalam_asuhan']" tone="success">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-slot:icon>
        </x-angsmart.stat-card>
        <x-angsmart.stat-card label="Menunggu Tindakan" :value="$stats['menunggu_tindakan']" tone="warning">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-slot:icon>
        </x-angsmart.stat-card>
        <x-angsmart.stat-card label="Perlu Handover" :value="$stats['perlu_handover']" tone="emergency">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </x-slot:icon>
        </x-angsmart.stat-card>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
        <div class="xl:col-span-2 bg-rs-surface border border-rs-border rounded-2xl p-6 shadow-sm">
            <h3 class="font-semibold text-rs-text-primary mb-6">Status Asuhan Keperawatan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                <x-angsmart.donut-chart
                    :percent="$donut['completion_percent']"
                    :completed="$donut['completed']"
                    :total="$donut['total']"
                />
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center justify-between gap-2">
                        <span class="flex items-center gap-2 text-rs-text-secondary">
                            <span class="h-2.5 w-2.5 rounded-full bg-rs-emergency"></span>
                            Tindakan Belum Selesai
                        </span>
                        <span class="font-semibold">{{ $donut['unfinished'] }}</span>
                    </li>
                    <li class="flex items-center justify-between gap-2">
                        <span class="flex items-center gap-2 text-rs-text-secondary">
                            <span class="h-2.5 w-2.5 rounded-full bg-rs-warning"></span>
                            Evaluasi Tertunda
                        </span>
                        <span class="font-semibold">{{ $donut['evaluation_pending'] }}</span>
                    </li>
                    <li class="flex items-center justify-between gap-2">
                        <span class="flex items-center gap-2 text-rs-text-secondary">
                            <span class="h-2.5 w-2.5 rounded-full bg-rs-success"></span>
                            Rencana Keperawatan Aktif
                        </span>
                        <span class="font-semibold">{{ $donut['active_plans'] }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <x-angsmart.quick-access />
    </div>

    <div class="bg-rs-surface border border-rs-border rounded-2xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-rs-border">
            <h3 class="font-semibold text-rs-text-primary">Pasien dengan Tindakan Belum Selesai</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-rs-background text-rs-text-secondary">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">No</th>
                        <th class="px-4 py-3 text-left font-semibold">Nama Pasien</th>
                        <th class="px-4 py-3 text-left font-semibold">No. RM</th>
                        <th class="px-4 py-3 text-left font-semibold">Bed</th>
                        <th class="px-4 py-3 text-left font-semibold">Tindakan Tertunda</th>
                        <th class="px-4 py-3 text-left font-semibold">Status</th>
                        <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-rs-border">
                    @foreach ($pendingPatients as $index => $row)
                        <tr class="hover:bg-rs-background/80">
                            <td class="px-4 py-3 text-rs-text-secondary">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-medium">{{ $row['name'] }}</td>
                            <td class="px-4 py-3">{{ $row['medical_record'] }}</td>
                            <td class="px-4 py-3">{{ $row['bed'] }}</td>
                            <td class="px-4 py-3">{{ $row['pending_action'] }}</td>
                            <td class="px-4 py-3">
                                <x-angsmart.status-badge :label="$row['row_status']" :tone="$row['row_status_tone']" />
                            </td>
                            <td class="px-4 py-3">
                                <a
                                    href="{{ route('apps.angsmart.patients.nursing-care', $row['slug']) }}"
                                    class="inline-flex rounded-lg border border-rs-border px-3 py-1.5 text-xs font-semibold text-rs-text-primary hover:bg-rs-background"
                                >Lihat</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-angsmart-layout>
