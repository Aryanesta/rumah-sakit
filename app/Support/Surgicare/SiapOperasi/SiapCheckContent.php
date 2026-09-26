<?php

namespace App\Support\Surgicare\SiapOperasi;

final class SiapCheckContent
{
    /**
     * @return list<array{
     *     id: string,
     *     prompt: string,
     *     options: list<string>,
     *     correct: string,
     *     feedback_correct: string,
     *     feedback_incorrect: string,
     *     review_route: string
     * }>
     */
    public static function questions(): array
    {
        return [
            [
                'id' => 'q1',
                'prompt' => 'Jika Anda belum memahami instruksi sebelum operasi, apa yang sebaiknya dilakukan?',
                'options' => ['Menebak sendiri', 'Mengikuti orang lain', 'Bertanya kepada tenaga kesehatan', 'Mengabaikannya'],
                'correct' => 'Bertanya kepada tenaga kesehatan',
                'feedback_correct' => 'Benar. Jika masih ada informasi yang belum jelas, tetap tanyakan kepada tenaga kesehatan yang merawat Anda.',
                'feedback_incorrect' => 'Mari pahami kembali. Informasi mengenai kondisi dan perawatan pasien perlu dikonfirmasi kepada tenaga kesehatan yang merawat.',
                'review_route' => 'apps.surgicare.siap-operasi.sebelum',
            ],
            [
                'id' => 'q2',
                'prompt' => 'Apakah pasien perlu menyampaikan alergi dan obat yang sedang digunakan kepada tenaga kesehatan?',
                'options' => ['Tidak perlu', 'Ya, perlu disampaikan', 'Hanya jika ditanya keluarga', 'Tidak tahu'],
                'correct' => 'Ya, perlu disampaikan',
                'feedback_correct' => 'Benar. Jika masih ada informasi yang belum jelas, tetap tanyakan kepada tenaga kesehatan yang merawat Anda.',
                'feedback_incorrect' => 'Mari pahami kembali. Informasi mengenai kondisi dan perawatan pasien perlu dikonfirmasi kepada tenaga kesehatan yang merawat.',
                'review_route' => 'apps.surgicare.siap-operasi.sebelum',
            ],
            [
                'id' => 'q3',
                'prompt' => 'Jika pasien mengalami keluhan atau perubahan kondisi setelah operasi, apa yang sebaiknya dilakukan?',
                'options' => ['Menunggu sampai hilang sendiri', 'Mengobati sendiri', 'Memberitahu perawat/tenaga kesehatan', 'Tidak perlu mengatakan kepada siapa pun'],
                'correct' => 'Memberitahu perawat/tenaga kesehatan',
                'feedback_correct' => 'Benar. Jika masih ada informasi yang belum jelas, tetap tanyakan kepada tenaga kesehatan yang merawat Anda.',
                'feedback_incorrect' => 'Mari pahami kembali. Informasi mengenai kondisi dan perawatan pasien perlu dikonfirmasi kepada tenaga kesehatan yang merawat.',
                'review_route' => 'apps.surgicare.siap-operasi.setelah',
            ],
            [
                'id' => 'q4',
                'prompt' => 'Apakah pasien boleh mengubah penggunaan obat sendiri?',
                'options' => ['Ya', 'Tidak', 'Boleh jika merasa tidak nyaman', 'Tidak tahu'],
                'correct' => 'Tidak',
                'feedback_correct' => 'Benar. Jika masih ada informasi yang belum jelas, tetap tanyakan kepada tenaga kesehatan yang merawat Anda.',
                'feedback_incorrect' => 'Mari pahami kembali. Informasi mengenai kondisi dan perawatan pasien perlu dikonfirmasi kepada tenaga kesehatan yang merawat.',
                'review_route' => 'apps.surgicare.siap-operasi.setelah',
            ],
            [
                'id' => 'q5',
                'prompt' => 'Jika keluarga melihat perubahan kondisi pasien yang mengkhawatirkan, apa yang sebaiknya dilakukan?',
                'options' => ['Menangani sendiri', 'Menunggu sampai besok', 'Segera memberitahu perawat/tenaga kesehatan', 'Tidak melakukan apa-apa'],
                'correct' => 'Segera memberitahu perawat/tenaga kesehatan',
                'feedback_correct' => 'Benar. Jika masih ada informasi yang belum jelas, tetap tanyakan kepada tenaga kesehatan yang merawat Anda.',
                'feedback_incorrect' => 'Mari pahami kembali. Informasi mengenai kondisi dan perawatan pasien perlu dikonfirmasi kepada tenaga kesehatan yang merawat.',
                'review_route' => 'apps.surgicare.siap-operasi.keluarga',
            ],
        ];
    }

    public static function intro(): string
    {
        return 'Sudah paham? Yuk, cek sebentar. Jawab beberapa pertanyaan sederhana untuk membantu mengetahui informasi yang sudah Anda pahami dan bagian yang mungkin masih perlu dijelaskan kembali.';
    }

    public static function metaLabel(): string
    {
        return '5 pertanyaan • ±2 menit';
    }

    /**
     * @return array{good: string, needs_review: string, closing: string}
     */
    public static function finalMessages(): array
    {
        return [
            'good' => 'PEMAHAMAN BAIK',
            'needs_review' => 'MASIH ADA INFORMASI YANG PERLU DIPERJELAS',
            'closing' => 'SIAP Check selesai. Anda telah menyelesaikan evaluasi pemahaman. Jika masih terdapat informasi yang belum jelas, silakan pelajari kembali materi atau tanyakan kepada perawat yang merawat Anda.',
        ];
    }

    /**
     * @return list<string>
     */
    public static function studiedMaterials(): array
    {
        return ['Sebelum Operasi', 'Setelah Operasi', 'Untuk Keluarga', 'SIAP Check'];
    }
}
