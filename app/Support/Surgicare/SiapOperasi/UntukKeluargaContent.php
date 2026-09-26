<?php

namespace App\Support\Surgicare\SiapOperasi;

final class UntukKeluargaContent
{
    /**
     * @return array{
     *     title: string,
     *     intro: string,
     *     blocks: list<array{key: string, heading: string, body: list<string>, checklist: list<array{id: string, label: string}>}>,
     *     dont_do: list<string>,
     *     master_checklist: array{title: string, items: list<array{id: string, label: string}>, feedback_partial: string, feedback_complete: string},
     *     question_notes_title: string,
     *     question_notes_placeholder: string
     * }
     */
    public static function page(): array
    {
        return [
            'title' => 'Untuk Keluarga',
            'intro' => 'Peran keluarga dalam mendukung pasien sebelum dan setelah operasi, serta hal yang tidak boleh dilakukan tanpa instruksi.',
            'blocks' => [
                [
                    'key' => 'a',
                    'heading' => 'A. Sebelum operasi',
                    'body' => ['Keluarga dapat memberikan dukungan emosional, menemani pasien, dan membantu mengingat informasi serta pertanyaan untuk tenaga kesehatan.'],
                    'checklist' => [
                        ['id' => 'a_dukung', 'label' => 'Saya memahami cara memberikan dukungan kepada pasien.'],
                        ['id' => 'a_ingat', 'label' => 'Saya dapat membantu pasien mengingat informasi.'],
                        ['id' => 'a_tanya', 'label' => 'Saya akan membantu pasien menyampaikan pertanyaan jika diperlukan.'],
                    ],
                ],
                [
                    'key' => 'b',
                    'heading' => 'B. Setelah operasi',
                    'body' => ['Keluarga dapat membantu kebutuhan pasien sesuai arahan, mengingatkan instruksi, dan melaporkan perubahan kondisi.'],
                    'checklist' => [
                        ['id' => 'b_dukung', 'label' => 'Saya memahami cara mendukung pasien setelah operasi.'],
                        ['id' => 'b_instruksi', 'label' => 'Saya akan mengikuti instruksi tenaga kesehatan.'],
                        ['id' => 'b_bantuan', 'label' => 'Saya akan meminta bantuan jika pasien membutuhkan bantuan.'],
                    ],
                ],
                [
                    'key' => 'c',
                    'heading' => 'C. Hal yang tidak dilakukan tanpa instruksi',
                    'body' => ['Jika ragu, jangan mengambil keputusan medis sendiri. Tanyakan kepada perawat.'],
                    'checklist' => [],
                ],
                [
                    'key' => 'd',
                    'heading' => 'D. Kapan keluarga harus meminta bantuan?',
                    'body' => ['Minta bantuan jika keluhan pasien semakin berat, ada perdarahan, sesak, perubahan luka, atau keluarga tidak memahami instruksi.'],
                    'checklist' => [],
                ],
            ],
            'dont_do' => [
                'Memberikan obat sendiri.',
                'Memberikan makanan/minuman tanpa memastikan pasien diperbolehkan.',
                'Membuka balutan.',
                'Melakukan perawatan luka sendiri.',
                'Memindahkan pasien tanpa mengetahui instruksi mobilisasi.',
                'Memaksakan pasien bergerak.',
                'Mengabaikan keluhan pasien.',
            ],
            'master_checklist' => [
                'title' => 'F. CHECKLIST KESIAPAN KELUARGA',
                'items' => [
                    ['id' => 'm_bantu', 'label' => 'Saya memahami cara membantu pasien.'],
                    ['id' => 'm_jangan', 'label' => 'Saya mengetahui hal yang tidak boleh dilakukan tanpa instruksi.'],
                    ['id' => 'm_bantuan', 'label' => 'Saya mengetahui kapan harus meminta bantuan.'],
                    ['id' => 'm_tanya', 'label' => 'Saya mengetahui kepada siapa harus bertanya.'],
                    ['id' => 'm_lapor', 'label' => 'Saya memahami pentingnya melaporkan perubahan kondisi pasien.'],
                    ['id' => 'm_keputusan', 'label' => 'Saya mengetahui bahwa keputusan medis tetap dilakukan oleh tenaga kesehatan.'],
                ],
                'feedback_partial' => 'Masih ada informasi yang perlu dipahami. Silakan pelajari kembali atau tanyakan kepada perawat.',
                'feedback_complete' => 'Panduan keluarga selesai.',
            ],
            'question_notes_title' => 'E. Catat pertanyaan keluarga',
            'question_notes_placeholder' => 'Apa yang ingin saya tanyakan kepada perawat? (contoh: Kapan pasien boleh mulai berjalan?)',
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
