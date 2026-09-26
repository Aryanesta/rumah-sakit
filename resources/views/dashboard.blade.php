<x-launcher-layout>
    <div class="animate-page-enter w-full max-w-4xl">
        <header class="mb-10 sm:mb-12">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-rs-text-primary">
                {{ $greeting }}
            </h1>
            <p class="mt-3 text-base sm:text-lg text-rs-text-secondary">
                Pilih aplikasi untuk melanjutkan
            </p>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
            @foreach ($applications as $application)
                <x-application-launcher-card
                    :href="route($application['route'])"
                    :label="$application['label']"
                    :icon="$application['icon']"
                    :variant="$application['variant']"
                />
            @endforeach
        </div>
    </div>
</x-launcher-layout>
