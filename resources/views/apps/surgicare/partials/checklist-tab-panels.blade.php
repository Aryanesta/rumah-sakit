@if ($activeTab === 'data')
    <div class="bg-rs-surface border border-rs-border rounded-2xl p-6 shadow-sm space-y-4">
        <h3 class="font-semibold text-rs-text-primary">Data Pasien</h3>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <dt class="text-rs-text-secondary">Nama</dt>
                <dd class="font-medium">{{ $patient['name'] }}</dd>
            </div>
            <div>
                <dt class="text-rs-text-secondary">No. RM</dt>
                <dd class="font-medium">{{ $patient['medical_record'] }}</dd>
            </div>
            <div>
                <dt class="text-rs-text-secondary">Usia</dt>
                <dd class="font-medium">{{ $patient['age'] }} Tahun</dd>
            </div>
            <div>
                <dt class="text-rs-text-secondary">Diagnosis</dt>
                <dd class="font-medium">{{ $patient['diagnosis'] }}</dd>
            </div>
            <div>
                <dt class="text-rs-text-secondary">Jenis Tindakan</dt>
                <dd class="font-medium">{{ $patient['procedure'] }}</dd>
            </div>
            <div>
                <dt class="text-rs-text-secondary">Ruangan / Bed</dt>
                <dd class="font-medium">{{ $patient['room'] }} · Bed {{ $patient['bed'] }}</dd>
            </div>
        </dl>
        <p class="text-xs text-rs-text-secondary">Ringkasan identitas pasien (mode demo).</p>
    </div>
@elseif ($activeTab === 'catatan')
    <div class="bg-rs-surface border border-rs-border rounded-2xl p-6 shadow-sm">
        <h3 class="font-semibold text-rs-text-primary mb-3">Catatan</h3>
        <textarea
            rows="6"
            class="w-full rounded-xl border-rs-border text-sm focus:border-rs-primary focus:ring-rs-primary"
            placeholder="Tulis catatan verifikasi perawat..."
            readonly
        >Mode demo — catatan belum disimpan.</textarea>
    </div>
@endif
