<x-surgicare-layout breadcrumb="Beranda › Monitoring Akun Pasien">
    <x-surgicare.page-header title="Monitoring Akun Pasien" subtitle="Pantau status keterbacaan panduan SIAP OPERASI oleh pasien (mode demo — data dari cache)." />

    <div class="bg-rs-surface border border-rs-border rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-rs-background text-rs-text-secondary">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Nama Pasien</th>
                        <th class="px-4 py-3 text-left font-semibold">No. RM</th>
                        <th class="px-4 py-3 text-left font-semibold">Guide Pre-OP</th>
                        <th class="px-4 py-3 text-left font-semibold">Guide Post-OP</th>
                        <th class="px-4 py-3 text-left font-semibold">Peringatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-rs-border">
                    @foreach ($rows as $row)
                        <tr class="hover:bg-rs-background/80">
                            <td class="px-4 py-3 font-medium">{{ $row['name'] }}</td>
                            <td class="px-4 py-3">{{ $row['medical_record'] }}</td>
                            <td class="px-4 py-3">
                                <x-surgicare.status-badge
                                    :label="$row['pre_op_status']"
                                    :tone="$row['pre_op_status'] === 'Sudah' ? 'success' : 'warning'"
                                />
                                @if ($row['pre_op_at'])
                                    <p class="text-xs text-rs-text-secondary mt-1">{{ $row['pre_op_at'] }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <x-surgicare.status-badge
                                    :label="$row['post_op_status']"
                                    :tone="$row['post_op_status'] === 'Sudah' ? 'success' : 'warning'"
                                />
                                @if ($row['post_op_at'])
                                    <p class="text-xs text-rs-text-secondary mt-1">{{ $row['post_op_at'] }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($row['warning_level'] === 'red')
                                    <x-surgicare.status-badge label="Guide belum — operasi dekat" tone="emergency" />
                                @elseif ($row['warning_level'] === 'yellow')
                                    <x-surgicare.status-badge label="Guide belum — perlu follow-up" tone="warning" />
                                @else
                                    <span class="text-rs-text-secondary">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-surgicare-layout>
