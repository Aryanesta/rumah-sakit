<?php

namespace App\Support\Surgicare;

use App\Enums\Angsmart\SurgicalPhase;
use App\Support\Hospital\SharedPatientCatalog;
use App\Support\Surgicare\SiapOperasi\GuideProgressRepository;
use Illuminate\Support\Carbon;

/**
 * Static demo payloads for the Surgicare nurse UI mock.
 * Display fields may differ from SharedPatientCatalog for screenshot fidelity.
 */
final class SurgicareDemoData
{
    public const DEMO_NURSE_NAME = 'Ns. Made Suryani';

    public const DEMO_NURSE_ROLE = 'Perawat (PP)';

    public const DEFAULT_PRE_OP_SLUG = 'budi-santoso';

    public const DEFAULT_POST_OP_SLUG = 'sari-dewi';

    /**
     * @return array{
     *     total_bedah: int,
     *     pre_op_today: int,
     *     post_op_today: int,
     *     alert_aktif: int
     * }
     */
    public static function dashboardStats(): array
    {
        $guideComplete = GuideProgressRepository::countPreOpGuideComplete();

        return [
            'total_bedah' => 18,
            'pre_op_today' => 8,
            'post_op_today' => 10,
            'alert_aktif' => 3,
            'pasien_baca_guide' => $guideComplete,
        ];
    }

    public static function scheduledSurgeryAt(string $slug): ?Carbon
    {
        return match ($slug) {
            'budi-santoso' => now()->addMinutes(90),
            default => null,
        };
    }

    /**
     * @return list<array{
     *     slug: string,
     *     name: string,
     *     medical_record: string,
     *     procedure: string,
     *     phase: SurgicalPhase,
     *     status_label: string,
     *     status_tone: string
     * }>
     */
    public static function todayPatients(): array
    {
        return [
            [
                'slug' => 'budi-santoso',
                'name' => 'Tn. Budi Santoso',
                'medical_record' => '123456',
                'procedure' => 'Laparatomi',
                'phase' => SurgicalPhase::PreOp,
                'status_label' => 'Belum Checklist',
                'status_tone' => 'warning',
            ],
            [
                'slug' => 'sari-dewi',
                'name' => 'Ny. Sari Dewi',
                'medical_record' => '234567',
                'procedure' => 'ORIF',
                'phase' => SurgicalPhase::PostOp,
                'status_label' => 'Dalam Observasi',
                'status_tone' => 'info',
            ],
            [
                'slug' => 'agus-pratama',
                'name' => 'Tn. Agus',
                'medical_record' => '345678',
                'procedure' => 'Hemoroidektomi',
                'phase' => SurgicalPhase::PreOp,
                'status_label' => 'Checklist Selesai',
                'status_tone' => 'success',
            ],
            [
                'slug' => 'ny-ratna',
                'name' => 'Ny. Ratna',
                'medical_record' => '456789',
                'procedure' => 'Cholecystectomy',
                'phase' => SurgicalPhase::PostOp,
                'status_label' => 'Dalam Observasi',
                'status_tone' => 'info',
            ],
        ];
    }

    /**
     * @return array<string, array{
     *     phase: SurgicalPhase,
     *     procedure: string,
     *     checklist_status: string,
     *     checklist_status_tone: string,
     *     display_age: int|null,
     *     display_diagnosis: string|null,
     *     display_name: string|null
     * }>
     */
    private static function patientExtensions(): array
    {
        return [
            'budi-santoso' => [
                'phase' => SurgicalPhase::PreOp,
                'procedure' => 'Laparatomi',
                'checklist_status' => 'Belum Checklist',
                'checklist_status_tone' => 'warning',
                'display_age' => 45,
                'display_diagnosis' => 'Appendisitis',
                'display_name' => null,
            ],
            'siti-rahayu' => [
                'phase' => SurgicalPhase::PostOp,
                'procedure' => 'Kolektomi',
                'checklist_status' => 'Dalam Observasi',
                'checklist_status_tone' => 'info',
                'display_age' => null,
                'display_diagnosis' => null,
                'display_name' => null,
            ],
            'made-wijaya' => [
                'phase' => SurgicalPhase::PostOp,
                'procedure' => 'Appendektomi',
                'checklist_status' => 'Checklist Selesai',
                'checklist_status_tone' => 'success',
                'display_age' => null,
                'display_diagnosis' => null,
                'display_name' => null,
            ],
            'dewi-kartika' => [
                'phase' => SurgicalPhase::PreOp,
                'procedure' => 'Observasi',
                'checklist_status' => 'Belum Checklist',
                'checklist_status_tone' => 'warning',
                'display_age' => null,
                'display_diagnosis' => null,
                'display_name' => null,
            ],
            'agus-pratama' => [
                'phase' => SurgicalPhase::PreOp,
                'procedure' => 'Hemoroidektomi',
                'checklist_status' => 'Checklist Selesai',
                'checklist_status_tone' => 'success',
                'display_age' => null,
                'display_diagnosis' => null,
                'display_name' => null,
            ],
            'sari-dewi' => [
                'phase' => SurgicalPhase::PostOp,
                'procedure' => 'ORIF',
                'checklist_status' => 'Dalam Observasi',
                'checklist_status_tone' => 'info',
                'display_age' => 62,
                'display_diagnosis' => 'Ca. Coli',
                'display_name' => 'Ny. Seri Dewi',
            ],
            'ny-ratna' => [
                'phase' => SurgicalPhase::PostOp,
                'procedure' => 'Cholecystectomy',
                'checklist_status' => 'Dalam Observasi',
                'checklist_status_tone' => 'info',
                'display_age' => 55,
                'display_diagnosis' => 'Kolelitiasis',
                'display_name' => null,
            ],
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
     *     phase: SurgicalPhase,
     *     procedure: string,
     *     checklist_status: string,
     *     checklist_status_tone: string
     * }>
     */
    public static function patients(): array
    {
        $extensions = self::patientExtensions();
        $patients = [];

        foreach (SharedPatientCatalog::corePatients() as $core) {
            $extra = $extensions[$core['slug']] ?? [
                'phase' => SurgicalPhase::PostOp,
                'procedure' => 'Rawat Inap',
                'checklist_status' => 'Dalam Observasi',
                'checklist_status_tone' => 'info',
                'display_age' => null,
                'display_diagnosis' => null,
                'display_name' => null,
            ];

            $patients[] = self::mergePatient($core, $extra);
        }

        foreach (self::extraPatients() as $core) {
            $extra = $extensions[$core['slug']];
            $patients[] = self::mergePatient($core, $extra);
        }

        return $patients;
    }

    /**
     * @param  array<string, mixed>  $core
     * @param  array<string, mixed>  $extra
     * @return array<string, mixed>
     */
    private static function mergePatient(array $core, array $extra): array
    {
        return [
            'slug' => $core['slug'],
            'name' => $extra['display_name'] ?? $core['name'],
            'medical_record' => $core['medical_record'],
            'age' => $extra['display_age'] ?? $core['age'],
            'room' => $core['room'],
            'bed' => $core['bed'],
            'diagnosis' => $extra['display_diagnosis'] ?? $core['diagnosis'],
            'phase' => $extra['phase'],
            'procedure' => $extra['procedure'],
            'checklist_status' => $extra['checklist_status'],
            'checklist_status_tone' => $extra['checklist_status_tone'],
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
     *     diagnosis: string
     * }>
     */
    private static function extraPatients(): array
    {
        return [
            [
                'slug' => 'sari-dewi',
                'name' => 'Ny. Sari Dewi',
                'medical_record' => '254067',
                'age' => 62,
                'room' => 'Angsoka 1',
                'bed' => '104',
                'diagnosis' => 'Ca. Coli',
            ],
            [
                'slug' => 'ny-ratna',
                'name' => 'Ny. Ratna',
                'medical_record' => '456789',
                'age' => 55,
                'room' => 'Angsoka 2',
                'bed' => '205',
                'diagnosis' => 'Kolelitiasis',
            ],
        ];
    }

    public static function findPatient(string $slug): ?array
    {
        foreach (self::patients() as $patient) {
            if ($patient['slug'] === $slug) {
                return $patient;
            }
        }

        return null;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function patientsForFrontend(): array
    {
        return array_map(function (array $patient): array {
            $patient['phase'] = $patient['phase']->value;

            return $patient;
        }, self::patients());
    }

    /**
     * @return list<string>
     */
    public static function phaseFilterOptions(): array
    {
        return ['Semua Fase', 'Pre-Op', 'Post-Op'];
    }

    /**
     * @return list<array{
     *     title: string,
     *     items: list<array{
     *         id: string,
     *         label: string,
     *         checked: bool
     *     }>
     * }>
     */
    public static function preOpChecklist(string $slug): array
    {
        if (self::findPatient($slug) === null) {
            return [];
        }

        return [
            [
                'title' => 'Persiapan Fisik',
                'items' => [
                    ['id' => 'puasa', 'label' => 'Puasa sesuai instruksi (6–8 jam)', 'checked' => true],
                    ['id' => 'lab', 'label' => 'Pemeriksaan laboratorium lengkap', 'checked' => true],
                    ['id' => 'ekg', 'label' => 'EKG dalam batas normal', 'checked' => true],
                    ['id' => 'consent', 'label' => 'Persetujuan tindakan (Informed Consent)', 'checked' => true],
                ],
            ],
            [
                'title' => 'Persiapan Alat & Administrasi',
                'items' => [
                    ['id' => 'alat', 'label' => 'Alat operasi siap', 'checked' => true],
                    ['id' => 'darah', 'label' => 'Darah cadangan (jika diperlukan)', 'checked' => true],
                    ['id' => 'dokumen', 'label' => 'Dokumentasi administrasi lengkap', 'checked' => true],
                ],
            ],
        ];
    }

    /**
     * @return list<array{
     *     title: string,
     *     type: string,
     *     items: list<array<string, mixed>>
     * }>
     */
    public static function postOpChecklist(string $slug): array
    {
        if (self::findPatient($slug) === null) {
            return [];
        }

        return [
            [
                'title' => 'Kondisi Umum',
                'type' => 'select',
                'items' => [
                    [
                        'id' => 'kesadaran',
                        'label' => 'Kesadaran (GCS)',
                        'value' => 'Compos Mentis',
                        'options' => ['Compos Mentis', 'Somnolen', 'Delirium'],
                    ],
                    [
                        'id' => 'ttv',
                        'label' => 'Tanda vital stabil',
                        'value' => 'Stabil',
                        'options' => ['Stabil', 'Tidak stabil'],
                    ],
                    [
                        'id' => 'nyeri',
                        'label' => 'Nyeri terkontrol',
                        'value' => 'Nyeri ringan',
                        'options' => ['Nyeri ringan', 'Nyeri sedang', 'Nyeri berat'],
                    ],
                ],
            ],
            [
                'title' => 'Luka Operasi',
                'type' => 'checkbox',
                'items' => [
                    ['id' => 'balutan', 'label' => 'Balutan bersih dan kering', 'checked' => true],
                    ['id' => 'perdarahan', 'label' => 'Tidak ada tanda perdarahan', 'checked' => true],
                    ['id' => 'drain', 'label' => 'Drain/selang terpasang (jika ada)', 'checked' => true],
                ],
            ],
            [
                'title' => 'Rencana Tindak Lanjut',
                'type' => 'checkbox',
                'items' => [
                    ['id' => 'mobilisasi', 'label' => 'Mobilisasi bertahap', 'checked' => true],
                    ['id' => 'edukasi', 'label' => 'Edukasi perawatan luka', 'checked' => true],
                    ['id' => 'monitoring', 'label' => 'Monitoring lab (Hb, WBC, dll)', 'checked' => true],
                ],
            ],
        ];
    }

    public static function checklistRouteForPatient(array $patient): string
    {
        $phase = $patient['phase'] instanceof SurgicalPhase
            ? $patient['phase']
            : ($patient['phase'] === 'pre_op' ? SurgicalPhase::PreOp : SurgicalPhase::PostOp);

        if ($phase === SurgicalPhase::PreOp) {
            return route('apps.surgicare.patients.pre-op-checklist', $patient['slug']);
        }

        return route('apps.surgicare.patients.post-op-checklist', $patient['slug']);
    }
}
