/**
 * Client-side Morse Fall Scale — keep scoring thresholds aligned with App\Support\Ansafe\MorseFallScale.
 */
export function ansafeMfsForm(dimensions, initialSelections) {
    const pointsByValue = {};

    dimensions.forEach((dimension) => {
        pointsByValue[dimension.key] = {};
        dimension.options.forEach((option) => {
            pointsByValue[dimension.key][option.value] = option.points;
        });
    });

    return {
        dimensions,
        selections: { ...initialSelections },
        demoMessage: '',

        total() {
            return Object.entries(this.selections).reduce((sum, [key, value]) => {
                return sum + (pointsByValue[key]?.[value] ?? 0);
            }, 0);
        },

        category() {
            const total = this.total();

            if (total <= 24) {
                return 'rendah';
            }

            if (total <= 44) {
                return 'sedang';
            }

            return 'tinggi';
        },

        categoryLabel() {
            const map = {
                rendah: 'Risiko Rendah',
                sedang: 'Risiko Sedang',
                tinggi: 'RISIKO TINGGI',
            };

            return map[this.category()];
        },

        protocolMessage() {
            const map = {
                rendah:
                    'Pasien termasuk kategori risiko jatuh rendah. Lanjutkan observasi rutin sesuai protokol.',
                sedang:
                    'Pasien termasuk kategori risiko jatuh sedang. Terapkan intervensi pencegahan standar.',
                tinggi:
                    'Pasien termasuk dalam kategori risiko jatuh tinggi. Lakukan intervensi pencegahan sesuai protokol.',
            };

            return map[this.category()];
        },

        showDemoSave() {
            this.demoMessage =
                'Demo: penyimpanan belum terhubung ke server. Data tidak disimpan.';
        },
    };
}

export function ansafeEducationFilter(videos) {
    return {
        videos,
        category: 'semua',
        search: '',

        filteredVideos() {
            const term = this.search.trim().toLowerCase();

            return this.videos.filter((video) => {
                const matchesCategory =
                    this.category === 'semua' || video.category === this.category;

                const matchesSearch =
                    term === '' || video.title.toLowerCase().includes(term);

                return matchesCategory && matchesSearch;
            });
        },
    };
}
