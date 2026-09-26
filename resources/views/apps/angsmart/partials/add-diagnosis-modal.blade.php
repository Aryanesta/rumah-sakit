<div
    x-data="{ open: false, selected: @js($masterDiagnoses[0]['id'] ?? '') }"
    @open-add-diagnosis-modal.window="open = true"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    role="dialog"
    aria-modal="true"
>
    <div class="absolute inset-0 bg-black/40" @click="open = false"></div>

    <div class="relative w-full max-w-lg rounded-2xl bg-rs-surface border border-rs-border shadow-xl p-6">
        <h2 class="text-lg font-bold text-rs-text-primary mb-4">Tambah Diagnosa Keperawatan</h2>

        <label for="master_diagnosis" class="block text-sm font-medium mb-2">Pilih dari master</label>
        <select id="master_diagnosis" x-model="selected" class="w-full rounded-xl border-rs-border text-sm mb-4">
            @foreach ($masterDiagnoses as $item)
                <option value="{{ $item['id'] }}">{{ $item['title'] }}</option>
            @endforeach
        </select>

        @foreach ($masterDiagnoses as $item)
            <div x-show="selected === @js($item['id'])" class="text-sm space-y-2 mb-4">
                <p><span class="text-rs-text-secondary">Tujuan:</span> {{ $item['goal'] }}</p>
                <p><span class="text-rs-text-secondary">Intervensi:</span> {{ $item['intervention'] }}</p>
            </div>
        @endforeach

        <div class="flex justify-end gap-3">
            <button type="button" @click="open = false" class="rounded-xl border border-rs-border px-4 py-2 text-sm font-semibold">Batal</button>
            <button type="button" @click="open = false" class="rounded-xl bg-rs-primary px-4 py-2 text-sm font-semibold text-white">Simpan (demo)</button>
        </div>
    </div>
</div>
