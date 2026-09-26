<?php

namespace App\Support\Surgicare\SiapOperasi;

final class SiapOperasiDashboardContent
{
    /**
     * @return array{
     *     title: string,
     *     tagline: string,
     *     intro: string,
     *     important_notice: string,
     *     menu_cards: list<array{title: string, description: string, route: string}>,
     *     siap_check_cta: array{title: string, description: string, route: string}
     * }
     */
    public static function page(): array
    {
        return [
            'title' => 'SIAP OPERASI',
            'tagline' => 'Lebih Siap, Lebih Paham, Lebih Aman.',
            'subtitle' => 'Sistem Informasi dan Edukasi Persiapan Operasi',
            'intro' => 'Selamat datang di SIAP OPERASI. SIAP OPERASI membantu pasien dan keluarga memahami hal-hal yang perlu diketahui sebelum operasi, setelah operasi, serta peran keluarga dalam mendukung proses perawatan. Gunakan informasi ini sebagai pendamping edukasi yang diberikan oleh tenaga kesehatan.',
            'important_notice' => 'Informasi dalam SIAP OPERASI merupakan media pendukung edukasi. Informasi ini tidak menggantikan instruksi dokter, perawat, SOP rumah sakit, informed consent, maupun keputusan klinis individual.',
            'menu_cards' => [
                [
                    'title' => 'Sebelum Operasi',
                    'description' => 'Apa yang perlu saya pahami dan persiapkan sebelum operasi?',
                    'route' => 'apps.surgicare.siap-operasi.sebelum',
                ],
                [
                    'title' => 'Setelah Operasi',
                    'description' => 'Apa yang perlu saya ketahui selama proses pemulihan?',
                    'route' => 'apps.surgicare.siap-operasi.setelah',
                ],
                [
                    'title' => 'Untuk Keluarga',
                    'description' => 'Bagaimana keluarga dapat membantu pasien?',
                    'route' => 'apps.surgicare.siap-operasi.keluarga',
                ],
            ],
            'siap_check_cta' => [
                'title' => 'SIAP Check',
                'description' => 'Sudah memahami informasinya? Yuk, cek pemahaman Anda.',
                'route' => 'apps.surgicare.siap-operasi.siap-check',
            ],
        ];
    }
}
