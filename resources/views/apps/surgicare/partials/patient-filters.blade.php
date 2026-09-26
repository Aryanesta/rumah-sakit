<div class="flex flex-col gap-3 lg:flex-row lg:items-center">
    <label class="flex-1 relative">
        <span class="sr-only">Cari pasien</span>
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-rs-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input
            type="search"
            x-model="search"
            placeholder="Cari nama pasien / No. RM / diagnosa..."
            class="w-full rounded-xl border-rs-border bg-rs-surface pl-10 pr-4 py-2.5 text-sm focus:border-rs-primary focus:ring-rs-primary"
        />
    </label>

    <select x-model="phase" class="rounded-xl border-rs-border bg-rs-surface text-sm focus:border-rs-primary focus:ring-rs-primary min-w-[10rem]">
        @foreach ($phaseOptions as $option)
            <option value="{{ $option }}">{{ $option }}</option>
        @endforeach
    </select>
</div>
