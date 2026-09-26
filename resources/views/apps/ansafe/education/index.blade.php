<x-ansafe-layout breadcrumb="Beranda › Education Center">
    <div class="mb-6 rounded-2xl border border-rs-border bg-rs-surface p-6 sm:p-8">
        <h1 class="text-2xl font-bold text-rs-primary-dark">Edukasi Mencegah Jatuh untuk Pasien dan Keluarga</h1>
        <p class="mt-2 text-sm text-rs-text-secondary max-w-3xl">
            Video dan materi edukasi untuk meningkatkan kesadaran pencegahan risiko jatuh di rumah sakit dan di rumah.
        </p>
    </div>

    <div
        x-data="ansafeEducationFilter(@js($videos))"
        class="grid grid-cols-1 xl:grid-cols-4 gap-6"
    >
        <aside class="xl:col-span-1 space-y-4">
            <div class="bg-rs-surface border border-rs-border rounded-2xl p-4 shadow-sm">
                <h2 class="text-sm font-semibold text-rs-text-primary mb-3">Kategori Video</h2>
                <div class="space-y-1">
                    @foreach ([
                        'semua' => 'Semua Video',
                        'pasien' => 'Pasien',
                        'keluarga' => 'Keluarga',
                        'tips' => 'Tips Keselamatan',
                    ] as $key => $label)
                        <button
                            type="button"
                            @click="category = '{{ $key }}'"
                            :class="category === '{{ $key }}' ? 'bg-rs-primary-light/40 text-rs-primary-dark font-semibold' : 'text-rs-text-secondary hover:bg-rs-background'"
                            class="w-full text-left rounded-xl px-3 py-2 text-sm transition-colors"
                        >{{ $label }}</button>
                    @endforeach
                </div>
            </div>
        </aside>

        <div class="xl:col-span-2 space-y-4">
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-lg font-bold text-rs-text-primary">Daftar Video Edukasi</h2>
                <input
                    type="search"
                    x-model="search"
                    placeholder="Cari judul video..."
                    class="rounded-xl border-rs-border text-sm w-full max-w-xs focus:border-rs-primary focus:ring-rs-primary"
                />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <template x-for="video in filteredVideos()" :key="video.id">
                    <article class="bg-rs-surface border border-rs-border rounded-2xl overflow-hidden shadow-sm flex flex-col">
                        <div class="relative h-36" :class="video.thumbnail_color">
                            <span class="absolute bottom-2 right-2 rounded-md bg-black/70 px-2 py-0.5 text-xs text-white font-medium" x-text="video.duration"></span>
                        </div>
                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="font-semibold text-rs-text-primary text-sm leading-snug" x-text="video.title"></h3>
                            <div class="mt-2 flex flex-wrap gap-1">
                                <template x-for="tag in video.tags" :key="tag">
                                    <span class="rounded-full bg-rs-primary-light/50 text-rs-primary-dark px-2 py-0.5 text-xs font-medium" x-text="tag"></span>
                                </template>
                            </div>
                            <div class="mt-4 flex items-center gap-3">
                                <button type="button" class="inline-flex items-center gap-1 rounded-xl bg-rs-primary px-3 py-2 text-xs font-semibold text-white hover:bg-rs-primary-dark">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    Tonton
                                </button>
                                <button type="button" class="text-xs font-semibold text-rs-primary hover:text-rs-primary-dark">Detail</button>
                            </div>
                        </div>
                    </article>
                </template>
            </div>
        </div>

        <aside class="xl:col-span-1">
            <div class="bg-rs-surface border border-rs-border rounded-2xl p-4 shadow-sm">
                <h2 class="text-sm font-semibold text-rs-text-primary mb-3">Video sudah ditonton</h2>
                <ul class="space-y-3">
                    @foreach ($watched as $item)
                        <li class="flex items-start gap-2 text-sm">
                            <svg class="h-5 w-5 text-rs-success shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-rs-text-primary leading-snug">{{ $item['title'] }}</p>
                                <p class="text-xs text-rs-text-secondary mt-0.5">{{ $item['watched_at'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
</x-ansafe-layout>
