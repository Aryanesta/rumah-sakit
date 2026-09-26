<?php

namespace App\Support\Surgicare\SiapOperasi;

final class SebelumOperasiContent
{
    /**
     * @return array{
     *     title: string,
     *     intro: string,
     *     blocks: list<array{key: string, heading: string, body: list<string>, checklist: list<array{id: string, label: string}>}>,
     *     master_checklist: array{title: string, items: list<array{id: string, label: string}>, feedback_partial: string, feedback_complete: string}
     * }
     */
    public static function page(): array
    {
        return [
            'title' => 'Sebelum Operasi',
            'intro' => 'Website membantu pasien memahami dan mengingat edukasi, bukan menentukan instruksi medis secara mandiri. Ikuti instruksi tenaga kesehatan dan SOP Ruang Angsoka.',
            'blocks' => [
                [
                    'key' => 'a',
                    'heading' => 'A. Pahami rencana operasi',
                    'body' => [
                        'Pasien diarahkan untuk memahami tindakan yang akan dijalani, tujuan berdasarkan penjelasan tenaga kesehatan, serta kesempatan untuk bertanya.',
                    ],
                    'checklist' => [
                        ['id' => 'a_tindakan', 'label' => 'Saya mengetahui tindakan yang akan dilakukan.'],
                        ['id' => 'a_tujuan', 'label' => 'Saya memahami tujuan tindakan berdasarkan penjelasan tenaga kesehatan.'],
                        ['id' => 'a_tanya', 'label' => 'Saya sudah mendapatkan kesempatan untuk bertanya.'],
                        ['id' => 'a_kontak', 'label' => 'Saya mengetahui kepada siapa saya dapat bertanya jika masih belum jelas.'],
                    ],
                ],
                [
                    'key' => 'b',
                    'heading' => 'B. Sampaikan informasi kesehatan',
                    'body' => [
                        'Pasien diingatkan untuk menyampaikan alergi, obat yang digunakan, riwayat penyakit, riwayat tindakan, dan keluhan terbaru.',
                    ],
                    'checklist' => [
                        ['id' => 'b_alergi', 'label' => 'Saya sudah menyampaikan alergi yang saya ketahui.'],
                        ['id' => 'b_obat', 'label' => 'Saya sudah menyampaikan obat yang sedang digunakan.'],
                        ['id' => 'b_penyakit', 'label' => 'Saya sudah menyampaikan riwayat penyakit.'],
                        ['id' => 'b_riwayat', 'label' => 'Saya sudah menyampaikan riwayat operasi/tindakan sebelumnya.'],
                        ['id' => 'b_keluhan', 'label' => 'Saya sudah menyampaikan perubahan kondisi atau keluhan yang saya alami.'],
                    ],
                ],
                [
                    'key' => 'c',
                    'heading' => 'C. Persiapan fisik',
                    'body' => [
                        'Mencakup kebersihan diri, makan dan minum sesuai instruksi, obat, pemeriksaan, dan kebutuhan pribadi.',
                    ],
                    'checklist' => [
                        ['id' => 'c_kebersihan', 'label' => 'Saya memahami instruksi kebersihan diri.'],
                        ['id' => 'c_makan', 'label' => 'Saya memahami instruksi makan dan minum yang diberikan.'],
                        ['id' => 'c_obat', 'label' => 'Saya memahami instruksi terkait obat.'],
                        ['id' => 'c_pemeriksaan', 'label' => 'Saya mengetahui pemeriksaan yang perlu saya jalani.'],
                        ['id' => 'c_pribadi', 'label' => 'Saya sudah menyiapkan kebutuhan pribadi sesuai arahan.'],
                    ],
                ],
                [
                    'key' => 'd',
                    'heading' => 'D. Persiapan psikologis',
                    'body' => [
                        'Merasa khawatir sebelum operasi dapat terjadi. Pasien dapat menyampaikan kekhawatiran dan meminta penjelasan kembali kepada perawat.',
                    ],
                    'checklist' => [
                        ['id' => 'd_khawatir', 'label' => 'Saya sudah menyampaikan kekhawatiran yang saya rasakan.'],
                        ['id' => 'd_kontak', 'label' => 'Saya tahu kepada siapa saya dapat bertanya.'],
                        ['id' => 'd_penjelasan', 'label' => 'Saya merasa memiliki kesempatan untuk mendapatkan penjelasan kembali.'],
                    ],
                ],
            ],
            'master_checklist' => [
                'title' => 'E. CHECKLIST KESIAPAN SEBELUM OPERASI',
                'items' => [
                    ['id' => 'm_paham_tindakan', 'label' => 'Saya memahami tindakan yang akan dilakukan.'],
                    ['id' => 'm_paham_tujuan', 'label' => 'Saya memahami tujuan tindakan berdasarkan penjelasan tenaga kesehatan.'],
                    ['id' => 'm_tanya', 'label' => 'Saya tahu kepada siapa saya dapat bertanya.'],
                    ['id' => 'm_alergi', 'label' => 'Saya sudah menyampaikan alergi.'],
                    ['id' => 'm_obat', 'label' => 'Saya sudah menyampaikan obat yang digunakan.'],
                    ['id' => 'm_penyakit', 'label' => 'Saya sudah menyampaikan riwayat penyakit.'],
                    ['id' => 'm_riwayat', 'label' => 'Saya sudah menyampaikan riwayat operasi/tindakan sebelumnya.'],
                    ['id' => 'm_makan', 'label' => 'Saya memahami instruksi makan dan minum.'],
                    ['id' => 'm_obat_instruksi', 'label' => 'Saya memahami instruksi obat.'],
                    ['id' => 'm_persiapan', 'label' => 'Saya memahami persiapan lain yang diberikan tenaga kesehatan.'],
                    ['id' => 'm_pemeriksaan', 'label' => 'Saya sudah mengikuti pemeriksaan/persiapan yang diminta.'],
                    ['id' => 'm_komunikasi', 'label' => 'Saya sudah menyampaikan pertanyaan yang saya miliki.'],
                ],
                'feedback_partial' => 'Masih ada informasi yang perlu diperjelas. Silakan periksa kembali bagian yang belum dicentang dan tanyakan kepada perawat yang merawat Anda.',
                'feedback_complete' => 'Checklist selesai. Pastikan Anda tetap mengikuti instruksi tenaga kesehatan yang merawat Anda.',
            ],
        ];
    }

    /**
     * @return list<string>
     */
    public static function allChecklistItemIds(): array
    {
        $ids = [];
        $page = self::page();

        foreach ($page['blocks'] as $block) {
            foreach ($block['checklist'] as $item) {
                $ids[] = $item['id'];
            }
        }

        foreach ($page['master_checklist']['items'] as $item) {
            $ids[] = $item['id'];
        }

        return $ids;
    }

    /**
     * @return list<string>
     */
    public static function masterChecklistItemIds(): array
    {
        return array_column(self::page()['master_checklist']['items'], 'id');
    }
}
