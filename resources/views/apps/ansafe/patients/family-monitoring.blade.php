<x-ansafe-layout pageTitle="Monitoring Edukasi Keluarga">
    <x-ansafe.patient-header-card :patient="$patient" class="mb-6" />

    <div x-data="{ tab: 'riwayat' }" class="space-y-6">
        <div class="border-b border-rs-border flex gap-6">
            <button
                type="button"
                @click="tab = 'riwayat'"
                :class="tab === 'riwayat' ? 'border-amber-600 text-amber-600 font-semibold' : 'border-transparent text-rs-text-secondary'"
                class="pb-3 text-sm border-b-2 transition-colors"
            >
                Riwayat Edukasi
            </button>
            <button
                type="button"
                @click="tab = 'rekap'"
                :class="tab === 'rekap' ? 'border-amber-600 text-amber-600 font-semibold' : 'border-transparent text-rs-text-secondary'"
                class="pb-3 text-sm border-b-2 transition-colors"
            >
                Rekap Monitoring
            </button>
        </div>

        <div x-show="tab === 'riwayat'" x-cloak>
            <x-ansafe.page-header title="Riwayat Edukasi" />

            <div class="bg-rs-surface border border-rs-border rounded-2xl shadow-sm overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-rs-background text-rs-text-secondary">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Tanggal &amp; Waktu</th>
                            <th class="px-4 py-3 text-left font-semibold">Jenis Edukasi</th>
                            <th class="px-4 py-3 text-left font-semibold">Media</th>
                            <th class="px-4 py-3 text-left font-semibold">Yang Mengakses</th>
                            <th class="px-4 py-3 text-left font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-rs-border">
                        @forelse ($educationHistory as $row)
                            <tr>
                                <td class="px-4 py-3 text-rs-text-secondary">{{ $row['datetime'] }}</td>
                                <td class="px-4 py-3 font-medium text-rs-text-primary">{{ $row['type'] }}</td>
                                <td class="px-4 py-3">
                                    <span @class([
                                        'inline-flex items-center gap-1.5 text-xs font-semibold',
                                        'text-amber-600' => $row['media'] === 'video',
                                        'text-rs-emergency' => $row['media'] === 'pdf',
                                    ])>
                                        {{ $row['media_label'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $row['accessed_by'] }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1 text-emerald-700 font-medium">
                                        <svg class="h-4 w-4 text-rs-success" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        {{ $row['status'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-rs-text-secondary">Belum ada riwayat edukasi untuk pasien ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                <x-ansafe.page-header title="Monitoring Teach-Back" />

                <div class="bg-rs-surface border border-rs-border rounded-2xl shadow-sm overflow-hidden">
                    <table class="min-w-full text-sm">
                        <thead class="bg-rs-background text-rs-text-secondary">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                                <th class="px-4 py-3 text-left font-semibold">Materi yang Diberikan</th>
                                <th class="px-4 py-3 text-left font-semibold">Respon Keluarga</th>
                                <th class="px-4 py-3 text-left font-semibold">Perawat</th>
                                <th class="px-4 py-3 text-left font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-rs-border">
                            @forelse ($teachBackRows as $row)
                                <tr>
                                    <td class="px-4 py-3 text-rs-text-secondary">{{ $row['date'] }}</td>
                                    <td class="px-4 py-3 font-medium text-rs-text-primary">{{ $row['material'] }}</td>
                                    <td class="px-4 py-3">
                                        <span @class([
                                            'font-medium',
                                            'text-emerald-700' => $row['response_tone'] === 'success',
                                            'text-rs-emergency' => $row['response_tone'] === 'emergency',
                                        ])>{{ $row['family_response'] }}</span>
                                    </td>
                                    <td class="px-4 py-3">{{ $row['nurse'] }}</td>
                                    <td class="px-4 py-3">
                                        @if ($row['status_tone'] === 'success')
                                            <span class="inline-flex items-center gap-1 text-emerald-700 font-medium">
                                                <svg class="h-4 w-4 text-rs-success" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                {{ $row['status'] }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-rs-warning font-medium">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01"/></svg>
                                                {{ $row['status'] }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-rs-text-secondary">Belum ada data teach-back.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div x-show="tab === 'rekap'" x-cloak class="bg-rs-surface border border-rs-border rounded-2xl p-8 text-center text-rs-text-secondary">
            <p class="text-sm">Rekap monitoring agregat akan tersedia setelah integrasi backend.</p>
            <p class="mt-2 text-xs">Gunakan tab Riwayat Edukasi untuk melihat data demo pasien ini.</p>
        </div>
    </div>
</x-ansafe-layout>
