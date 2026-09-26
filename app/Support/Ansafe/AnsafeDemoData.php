<?php

namespace App\Support\Ansafe;

use App\Enums\Ansafe\FallRiskCategory;

final class AnsafeDemoData
{
    /**
     * @return array{total: int, rendah: int, sedang: int, tinggi: int, education_pending: int}
     */
    public static function dashboardStats(): array
    {
        return [
            'total' => 28,
            'rendah' => 14,
            'sedang' => 8,
            'tinggi' => 6,
            'education_pending' => 4,
        ];
    }

    /**
     * @return list<array{
     *     slug: string,
     *     name: string,
     *     medical_record: string,
     *     age: int,
     *     room: string,
     *     bed: string,
     *     diagnosis: string,
     *     risk: FallRiskCategory,
     *     last_assessment_at: string,
     *     mfs_selections: array<string, string>
     * }>
     */
    public static function patients(): array
    {
        return [
            [
                'slug' => 'budi-santoso',
                'name' => 'Tn. Budi Santoso',
                'medical_record' => '123456',
                'age' => 67,
                'room' => 'Angsoka 1',
                'bed' => '102',
                'diagnosis' => 'Fraktur Femur',
                'risk' => FallRiskCategory::Tinggi,
                'last_assessment_at' => '23 Sep 2024 08:15',
                'mfs_selections' => [
                    'history_of_falling' => 'yes',
                    'secondary_diagnosis' => 'no',
                    'ambulatory_aid' => 'furniture',
                    'iv_therapy' => 'no',
                    'gait' => 'normal',
                    'mental_status' => 'oriented',
                ],
            ],
            [
                'slug' => 'siti-rahayu',
                'name' => 'Ny. Siti Rahayu',
                'medical_record' => '123457',
                'age' => 54,
                'room' => 'Angsoka 1',
                'bed' => '105',
                'diagnosis' => 'Stroke',
                'risk' => FallRiskCategory::Sedang,
                'last_assessment_at' => '22 Sep 2024 14:30',
                'mfs_selections' => [
                    'history_of_falling' => 'no',
                    'secondary_diagnosis' => 'yes',
                    'ambulatory_aid' => 'crutch',
                    'iv_therapy' => 'yes',
                    'gait' => 'weak',
                    'mental_status' => 'oriented',
                ],
            ],
            [
                'slug' => 'made-wijaya',
                'name' => 'Tn. Made Wijaya',
                'medical_record' => '123458',
                'age' => 42,
                'room' => 'Angsoka 2',
                'bed' => '201',
                'diagnosis' => 'Appendektomi',
                'risk' => FallRiskCategory::Rendah,
                'last_assessment_at' => '23 Sep 2024 07:00',
                'mfs_selections' => [
                    'history_of_falling' => 'no',
                    'secondary_diagnosis' => 'no',
                    'ambulatory_aid' => 'none',
                    'iv_therapy' => 'no',
                    'gait' => 'normal',
                    'mental_status' => 'oriented',
                ],
            ],
            [
                'slug' => 'dewi-kartika',
                'name' => 'Ny. Dewi Kartika',
                'medical_record' => '123459',
                'age' => 71,
                'room' => 'Angsoka 1',
                'bed' => '108',
                'diagnosis' => 'Hipertensi',
                'risk' => FallRiskCategory::Tinggi,
                'last_assessment_at' => '21 Sep 2024 16:45',
                'mfs_selections' => [
                    'history_of_falling' => 'yes',
                    'secondary_diagnosis' => 'yes',
                    'ambulatory_aid' => 'furniture',
                    'iv_therapy' => 'no',
                    'gait' => 'impaired',
                    'mental_status' => 'forgets',
                ],
            ],
            [
                'slug' => 'agus-pratama',
                'name' => 'Tn. Agus Pratama',
                'medical_record' => '123460',
                'age' => 58,
                'room' => 'Angsoka 2',
                'bed' => '203',
                'diagnosis' => 'Diabetes Melitus',
                'risk' => FallRiskCategory::Sedang,
                'last_assessment_at' => '23 Sep 2024 09:20',
                'mfs_selections' => [
                    'history_of_falling' => 'no',
                    'secondary_diagnosis' => 'yes',
                    'ambulatory_aid' => 'none',
                    'iv_therapy' => 'yes',
                    'gait' => 'weak',
                    'mental_status' => 'oriented',
                ],
            ],
        ];
    }

    /**
     * @return array<string, array{
     *     slug: string,
     *     name: string,
     *     medical_record: string,
     *     age: int,
     *     room: string,
     *     bed: string,
     *     diagnosis: string,
     *     risk: FallRiskCategory,
     *     last_assessment_at: string,
     *     mfs_selections: array<string, string>
     * }>
     */
    public static function patientsBySlug(): array
    {
        $indexed = [];

        foreach (self::patients() as $patient) {
            $indexed[$patient['slug']] = $patient;
        }

        return $indexed;
    }

    public static function findPatient(string $slug): ?array
    {
        return self::patientsBySlug()[$slug] ?? null;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function patientsForFrontend(): array
    {
        return array_map(function (array $patient): array {
            $patient['risk'] = $patient['risk']->value;

            return $patient;
        }, self::patients());
    }

    /**
     * @return list<string>
     */
    public static function roomFilterOptions(): array
    {
        return ['Semua Kamar', 'Angsoka 1', 'Angsoka 2'];
    }

    /**
     * @return list<array{slug: string, name: string, risk: FallRiskCategory}>
     */
    public static function highRiskPatients(): array
    {
        return array_values(array_filter(
            self::patients(),
            fn (array $patient): bool => $patient['risk'] === FallRiskCategory::Tinggi
        ));
    }

    /**
     * @return list<array{
     *     id: string,
     *     title: string,
     *     category: string,
     *     duration: string,
     *     tags: list<string>,
     *     thumbnail_color: string
     * }>
     */
    public static function educationVideos(): array
    {
        return [
            [
                'id' => 'v1',
                'title' => 'Cara Mencegah Pasien Jatuh di Rumah Sakit',
                'category' => 'pasien',
                'duration' => '06:12',
                'tags' => ['Pasien', 'Keluarga'],
                'thumbnail_color' => 'bg-rs-primary-light',
            ],
            [
                'id' => 'v2',
                'title' => 'Penggunaan Rail Bed dengan Aman',
                'category' => 'keluarga',
                'duration' => '04:45',
                'tags' => ['Keluarga'],
                'thumbnail_color' => 'bg-rs-accent/40',
            ],
            [
                'id' => 'v3',
                'title' => 'Tips Keselamatan di Rumah Setelah Pulang',
                'category' => 'tips',
                'duration' => '08:20',
                'tags' => ['Tips Keselamatan'],
                'thumbnail_color' => 'bg-rs-warning/30',
            ],
            [
                'id' => 'v4',
                'title' => 'Cara Memanggil Perawat dengan Benar',
                'category' => 'pasien',
                'duration' => '03:30',
                'tags' => ['Pasien'],
                'thumbnail_color' => 'bg-rs-primary-light',
            ],
        ];
    }

    /**
     * @return list<array{title: string, watched_at: string}>
     */
    public static function watchedVideos(): array
    {
        return [
            ['title' => 'Cara Mencegah Pasien Jatuh di Rumah Sakit', 'watched_at' => '23 Sep 2026 09:12'],
            ['title' => 'Penggunaan Rail Bed dengan Aman', 'watched_at' => '22 Sep 2026 15:40'],
        ];
    }

    /**
     * @return list<array{
     *     datetime: string,
     *     type: string,
     *     media: string,
     *     media_label: string,
     *     accessed_by: string,
     *     status: string,
     *     status_tone: string
     * }>
     */
    public static function educationHistory(string $slug): array
    {
        if ($slug !== 'budi-santoso') {
            return [];
        }

        return [
            [
                'datetime' => '23 Sep 2026 09:12',
                'type' => 'Pencegahan Jatuh di Rumah Sakit',
                'media' => 'video',
                'media_label' => 'Video',
                'accessed_by' => 'Keluarga',
                'status' => 'Ditonton',
                'status_tone' => 'success',
            ],
            [
                'datetime' => '23 Sep 2026 10:05',
                'type' => 'Penggunaan Rail Bed',
                'media' => 'video',
                'media_label' => 'Video',
                'accessed_by' => 'Keluarga',
                'status' => 'Ditonton',
                'status_tone' => 'success',
            ],
            [
                'datetime' => '22 Sep 2026 14:20',
                'type' => 'Tips di Rumah',
                'media' => 'pdf',
                'media_label' => 'PDF',
                'accessed_by' => 'Pasien',
                'status' => 'Dibaca',
                'status_tone' => 'success',
            ],
        ];
    }

    /**
     * @return list<array{
     *     date: string,
     *     material: string,
     *     family_response: string,
     *     response_tone: string,
     *     nurse: string,
     *     status: string,
     *     status_tone: string
     * }>
     */
    public static function teachBackMonitoring(string $slug): array
    {
        if ($slug !== 'budi-santoso') {
            return [];
        }

        return [
            [
                'date' => '23 Sep 2026 10:20',
                'material' => 'Cara mencegah jatuh',
                'family_response' => 'Memahami dengan baik',
                'response_tone' => 'success',
                'nurse' => 'Ns. Made Suryani',
                'status' => 'Selesai',
                'status_tone' => 'success',
            ],
            [
                'date' => '23 Sep 2026 11:00',
                'material' => 'Penggunaan bel perawat',
                'family_response' => 'Perlu pengulangan',
                'response_tone' => 'emergency',
                'nurse' => 'Ns. Made Suryani',
                'status' => 'Perlu Edukasi',
                'status_tone' => 'warning',
            ],
        ];
    }
}
