<x-surgicare-layout breadcrumb="Beranda">
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-rs-primary-dark">Selamat Datang, {{ $nurseName }}</h1>
        <p class="mt-2 text-sm text-rs-text-secondary">Berikut adalah ringkasan kegiatan SURGICARE hari ini.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4 mb-8">
        <x-surgicare.stat-card label="Total Pasien Bedah" :value="$stats['total_bedah']" tone="success">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </x-slot:icon>
        </x-surgicare.stat-card>
        <x-surgicare.stat-card label="Pre-Op (Hari Ini)" :value="$stats['pre_op_today']" tone="primary">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </x-slot:icon>
        </x-surgicare.stat-card>
        <x-surgicare.stat-card label="Post-Op (Hari Ini)" :value="$stats['post_op_today']" tone="purple">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </x-slot:icon>
        </x-surgicare.stat-card>
        <x-surgicare.stat-card label="Alert Aktif" :value="$stats['alert_aktif']" tone="emergency">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </x-slot:icon>
        </x-surgicare.stat-card>
        <x-surgicare.stat-card label="Sudah Baca Guide" :value="$stats['pasien_baca_guide']" tone="success">
            <x-slot:icon>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </x-slot:icon>
        </x-surgicare.stat-card>
    </div>

    <div class="bg-rs-surface border border-rs-border rounded-2xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-rs-border">
            <h3 class="font-semibold text-rs-text-primary">Pasien Hari Ini</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-rs-background text-rs-text-secondary">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">No</th>
                        <th class="px-4 py-3 text-left font-semibold">Nama Pasien</th>
                        <th class="px-4 py-3 text-left font-semibold">No. RM</th>
                        <th class="px-4 py-3 text-left font-semibold">Jenis Tindakan</th>
                        <th class="px-4 py-3 text-left font-semibold">Fase</th>
                        <th class="px-4 py-3 text-left font-semibold">Status</th>
                        <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-rs-border">
                    @foreach ($todayPatients as $index => $row)
                        @php
                            $checklistUrl = \App\Support\Surgicare\SurgicareDemoData::checklistRouteForPatient($row);
                            $phaseLabel = $row['phase']->label();
                        @endphp
                        <tr class="hover:bg-rs-background/80">
                            <td class="px-4 py-3 text-rs-text-secondary">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-medium">{{ $row['name'] }}</td>
                            <td class="px-4 py-3">{{ $row['medical_record'] }}</td>
                            <td class="px-4 py-3">{{ $row['procedure'] }}</td>
                            <td class="px-4 py-3">{{ $phaseLabel }}</td>
                            <td class="px-4 py-3">
                                <x-surgicare.status-badge :label="$row['status_label']" :tone="$row['status_tone']" />
                                @if (! empty($row['guide_warning']))
                                    <x-surgicare.status-badge
                                        class="ml-1"
                                        :label="$row['guide_warning'] === 'red' ? 'Guide!' : 'Guide?'"
                                        :tone="$row['guide_warning'] === 'red' ? 'emergency' : 'warning'"
                                    />
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <a
                                    href="{{ $checklistUrl }}"
                                    class="inline-flex rounded-lg border border-rs-primary px-3 py-1.5 text-xs font-semibold text-rs-primary hover:bg-rs-primary/5"
                                >Lihat</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-surgicare-layout>
