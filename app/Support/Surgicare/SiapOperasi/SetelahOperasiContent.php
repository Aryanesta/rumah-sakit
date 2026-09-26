<?php

namespace App\Support\Surgicare\SiapOperasi;

final class SetelahOperasiContent
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
            'title' => 'Setelah Operasi',
            'intro' => 'Edukasi pemulihan setelah operasi. Website tidak digunakan untuk menentukan diagnosis atau keputusan medis individual.',
            'blocks' => [
                [
                    'key' => 'a',
                    'heading' => 'A. Proses pemulihan',
                    'body' => ['Setelah operasi pasien dapat menjalani pemantauan, istirahat, dan pemulihan bertahap sesuai instruksi tenaga kesehatan.'],
                    'checklist' => [
                        ['id' => 'a_pantau', 'label' => 'Saya memahami bahwa kondisi saya akan dipantau setelah operasi.'],
                        ['id' => 'a_bertahap', 'label' => 'Saya memahami bahwa pemulihan dilakukan secara bertahap.'],
                        ['id' => 'a_aktivitas', 'label' => 'Saya memahami bahwa aktivitas disesuaikan dengan kondisi dan instruksi tenaga kesehatan.'],
                    ],
                ],
                [
                    'key' => 'b',
                    'heading' => 'B. Nyeri',
                    'body' => ['Nyeri dapat dirasakan setelah operasi. Sampaikan nyeri dan perubahannya kepada perawat.'],
                    'checklist' => [
                        ['id' => 'b_lapor', 'label' => 'Saya tahu bahwa nyeri perlu disampaikan kepada perawat.'],
                        ['id' => 'b_berubah', 'label' => 'Saya akan memberitahu perawat jika nyeri bertambah atau berubah.'],
                        ['id' => 'b_tahan', 'label' => 'Saya tahu bahwa saya tidak perlu menahan keluhan tanpa melaporkannya.'],
                    ],
                ],
                [
                    'key' => 'c',
                    'heading' => 'C. Perawatan luka',
                    'body' => ['Ikuti instruksi perawatan luka dan laporkan perdarahan, perubahan luka, atau nyeri yang semakin berat.'],
                    'checklist' => [
                        ['id' => 'c_instruksi', 'label' => 'Saya memahami instruksi perawatan luka.'],
                        ['id' => 'c_balutan', 'label' => 'Saya tahu bahwa saya tidak boleh membuka balutan tanpa instruksi.'],
                        ['id' => 'c_perubahan', 'label' => 'Saya tahu bahwa perubahan pada luka perlu disampaikan kepada perawat.'],
                    ],
                ],
                [
                    'key' => 'd',
                    'heading' => 'D. Mobilisasi',
                    'body' => ['Bergerak dengan aman sesuai kondisi dan instruksi tenaga kesehatan.'],
                    'checklist' => [
                        ['id' => 'd_izin', 'label' => 'Saya mengetahui apakah saya sudah diperbolehkan bergerak.'],
                        ['id' => 'd_bantuan', 'label' => 'Saya mengetahui apakah saya membutuhkan bantuan.'],
                        ['id' => 'd_minta', 'label' => 'Saya akan meminta bantuan jika diperlukan.'],
                        ['id' => 'd_paksa', 'label' => 'Saya tidak akan memaksakan diri.'],
                    ],
                ],
                [
                    'key' => 'e',
                    'heading' => 'E. Makan dan minum',
                    'body' => ['Makan dan minum mengikuti instruksi tenaga kesehatan setelah operasi.'],
                    'checklist' => [
                        ['id' => 'e_instruksi', 'label' => 'Saya memahami bahwa makan dan minum mengikuti instruksi tenaga kesehatan.'],
                        ['id' => 'e_tanya', 'label' => 'Saya akan bertanya jika belum mengetahui kapan saya diperbolehkan makan/minum.'],
                    ],
                ],
                [
                    'key' => 'f',
                    'heading' => 'F. Obat',
                    'body' => ['Gunakan obat sesuai instruksi; jangan mengubah dosis atau menghentikan obat sendiri.'],
                    'checklist' => [
                        ['id' => 'f_pakai', 'label' => 'Saya memahami penggunaan obat sesuai instruksi.'],
                        ['id' => 'f_dosis', 'label' => 'Saya tidak akan mengubah dosis sendiri.'],
                        ['id' => 'f_stop', 'label' => 'Saya tidak akan menghentikan obat tanpa berkonsultasi.'],
                        ['id' => 'f_lapor', 'label' => 'Saya akan melaporkan keluhan terkait obat kepada tenaga kesehatan.'],
                    ],
                ],
                [
                    'key' => 'g',
                    'heading' => 'G. Kondisi yang perlu segera dilaporkan',
                    'body' => ['Segera laporkan keluhan yang semakin berat, perdarahan, sesak, demam, perubahan luka, atau kondisi tidak biasa lainnya.'],
                    'checklist' => [
                        ['id' => 'g_lapor', 'label' => 'Saya mengetahui bahwa perubahan kondisi perlu dilaporkan.'],
                        ['id' => 'g_kepada', 'label' => 'Saya mengetahui kepada siapa saya harus melapor.'],
                        ['id' => 'g_tunggu', 'label' => 'Saya memahami bahwa saya tidak perlu menunggu jika kondisi saya mengkhawatirkan.'],
                    ],
                ],
            ],
            'master_checklist' => [
                'title' => 'H. CHECKLIST SETELAH OPERASI',
                'items' => [
                    ['id' => 'm_pantau', 'label' => 'Saya memahami proses pemantauan setelah operasi.'],
                    ['id' => 'm_nyeri', 'label' => 'Saya tahu cara menyampaikan keluhan nyeri.'],
                    ['id' => 'm_luka', 'label' => 'Saya memahami instruksi perawatan luka.'],
                    ['id' => 'm_mobilisasi', 'label' => 'Saya tahu kapan harus meminta bantuan saat mobilisasi.'],
                    ['id' => 'm_makan', 'label' => 'Saya memahami instruksi makan dan minum.'],
                    ['id' => 'm_obat', 'label' => 'Saya memahami penggunaan obat sesuai instruksi.'],
                    ['id' => 'm_darurat', 'label' => 'Saya mengetahui kondisi yang perlu segera dilaporkan.'],
                    ['id' => 'm_bantuan', 'label' => 'Saya tahu kepada siapa saya harus meminta bantuan.'],
                ],
                'feedback_partial' => 'Masih ada bagian yang perlu Anda pahami. Silakan buka kembali materi yang belum dipahami atau tanyakan kepada perawat.',
                'feedback_complete' => 'Checklist pemulihan selesai. Tetap ikuti instruksi tenaga kesehatan yang merawat Anda.',
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
