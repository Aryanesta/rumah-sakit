<?php

namespace App\Support\Angsmart;

use App\Enums\Angsmart\CarePlanStatus;
use App\Enums\Angsmart\HandoverLockStatus;
use App\Enums\Angsmart\NursingActionStatus;
use App\Enums\Angsmart\NursingCareStatus;
use App\Enums\Angsmart\Shift;
use App\Enums\Angsmart\SurgicalPhase;
use App\Support\Hospital\SharedPatientCatalog;

final class AngsmartDemoData
{
    /**
     * @return array{
     *     total: int,
     *     dalam_asuhan: int,
     *     menunggu_tindakan: int,
     *     perlu_handover: int
     * }
     */
    public static function dashboardStats(): array
    {
        return [
            'total' => 32,
            'dalam_asuhan' => 28,
            'menunggu_tindakan' => 4,
            'perlu_handover' => 3,
        ];
    }

    /**
     * @return array{
     *     completion_percent: int,
     *     completed: int,
     *     total: int,
     *     unfinished: int,
     *     evaluation_pending: int,
     *     active_plans: int
     * }
     */
    public static function careStatusDonut(): array
    {
        return [
            'completion_percent' => 87,
            'completed' => 28,
            'total' => 32,
            'unfinished' => 4,
            'evaluation_pending' => 2,
            'active_plans' => 32,
        ];
    }

    /**
     * @return list<array{
     *     slug: string,
     *     name: string,
     *     medical_record: string,
     *     bed: string,
     *     pending_action: string,
     *     row_status: string,
     *     row_status_tone: string
     * }>
     */
    public static function pendingActionPatients(): array
    {
        return [
            [
                'slug' => 'budi-santoso',
                'name' => 'Tn. Budi Santoso',
                'medical_record' => '123456',
                'bed' => '102',
                'pending_action' => 'Mobilisasi dini',
                'row_status' => 'Perlu Evaluasi',
                'row_status_tone' => 'warning',
            ],
            [
                'slug' => 'siti-rahayu',
                'name' => 'Ny. Siti Aminah',
                'medical_record' => '123457',
                'bed' => '101',
                'pending_action' => 'Edukasi diet',
                'row_status' => 'Belum Selesai',
                'row_status_tone' => 'emergency',
            ],
            [
                'slug' => 'made-wijaya',
                'name' => 'Tn. Made Wijaya',
                'medical_record' => '123458',
                'bed' => '103',
                'pending_action' => 'Monitoring drain',
                'row_status' => 'Belum Selesai',
                'row_status_tone' => 'emergency',
            ],
        ];
    }

    /**
     * @return array<string, array{
     *     phase: SurgicalPhase,
     *     care_status: NursingCareStatus,
     *     procedure: string,
     *     needs_handover: bool
     * }>
     */
    private static function patientExtensions(): array
    {
        return [
            'budi-santoso' => [
                'phase' => SurgicalPhase::PostOp,
                'care_status' => NursingCareStatus::DalamAsuhan,
                'procedure' => 'ORIF',
                'needs_handover' => true,
            ],
            'siti-rahayu' => [
                'phase' => SurgicalPhase::PostOp,
                'care_status' => NursingCareStatus::MenungguTindakan,
                'procedure' => 'Kolektomi',
                'needs_handover' => false,
            ],
            'made-wijaya' => [
                'phase' => SurgicalPhase::PostOp,
                'care_status' => NursingCareStatus::MenungguTindakan,
                'procedure' => 'Appendektomi',
                'needs_handover' => true,
            ],
            'dewi-kartika' => [
                'phase' => SurgicalPhase::PreOp,
                'care_status' => NursingCareStatus::DalamAsuhan,
                'procedure' => 'Observasi',
                'needs_handover' => false,
            ],
            'agus-pratama' => [
                'phase' => SurgicalPhase::PreOp,
                'care_status' => NursingCareStatus::DalamAsuhan,
                'procedure' => 'Manajemen DM',
                'needs_handover' => false,
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
     *     care_status: NursingCareStatus,
     *     procedure: string,
     *     needs_handover: bool
     * }>
     */
    public static function patients(): array
    {
        $extensions = self::patientExtensions();
        $patients = [];

        foreach (SharedPatientCatalog::corePatients() as $core) {
            $extra = $extensions[$core['slug']] ?? [
                'phase' => SurgicalPhase::PostOp,
                'care_status' => NursingCareStatus::DalamAsuhan,
                'procedure' => 'Rawat Inap',
                'needs_handover' => false,
            ];

            $patients[] = array_merge($core, $extra);
        }

        $generated = self::generatedPatients();

        return array_merge($patients, $generated);
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
     *     care_status: NursingCareStatus,
     *     procedure: string,
     *     needs_handover: bool
     * }>
     */
    private static function generatedPatients(): array
    {
        $diagnoses = ['Pneumonia', 'Ca. Colon', 'Fraktur Femur', 'CHF', 'CKD', 'Gastritis', 'Asma'];
        $names = [
            'Ny. Siti Aminah', 'Tn. I Wayan', 'Ny. Putri Ayu', 'Tn. Hendra', 'Ny. Rina',
            'Tn. Joko', 'Ny. Maya', 'Tn. Bambang', 'Ny. Lestari', 'Tn. Rizky',
            'Ny. Ani', 'Tn. Doni', 'Ny. Fitri', 'Tn. Eko', 'Ny. Wulan',
            'Tn. Arif', 'Ny. Citra', 'Tn. Fajar', 'Ny. Diah', 'Tn. Gilang',
            'Ny. Hani', 'Tn. Ivan', 'Ny. Julia', 'Tn. Kevin', 'Ny. Lia',
            'Tn. Mario', 'Ny. Nina',
        ];

        $patients = [];
        $baseRm = 123461;

        foreach ($names as $index => $name) {
            $slug = 'pasien-'.($index + 6);
            $phase = $index % 3 === 0 ? SurgicalPhase::PreOp : SurgicalPhase::PostOp;
            $careStatus = $index % 5 === 0
                ? NursingCareStatus::MenungguTindakan
                : NursingCareStatus::DalamAsuhan;

            $patients[] = [
                'slug' => $slug,
                'name' => $name,
                'medical_record' => (string) ($baseRm + $index),
                'age' => 35 + ($index % 40),
                'room' => $index % 2 === 0 ? 'Angsoka 1' : 'Angsoka 2',
                'bed' => (string) (110 + $index),
                'diagnosis' => $diagnoses[$index % count($diagnoses)],
                'phase' => $phase,
                'care_status' => $careStatus,
                'procedure' => 'Rawat Inap',
                'needs_handover' => $index % 7 === 0,
            ];
        }

        return $patients;
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
            $patient['care_status'] = $patient['care_status']->value;

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
     * @return list<string>
     */
    public static function careStatusFilterOptions(): array
    {
        return ['Semua Status', 'Dalam Asuhan', 'Menunggu Tindakan'];
    }

    /**
     * @return list<array{
     *     id: string,
     *     name: string,
     *     status: NursingActionStatus
     * }>
     */
    public static function nursingActionsFor(string $slug): array
    {
        if ($slug !== 'budi-santoso') {
            return [
                ['id' => 'observasi', 'name' => 'Observasi TTV', 'status' => NursingActionStatus::Selesai],
                ['id' => 'kebersihan', 'name' => 'Kebersihan diri', 'status' => NursingActionStatus::DalamProses],
            ];
        }

        return [
            ['id' => 'mobilisasi', 'name' => 'Mobilisasi dini', 'status' => NursingActionStatus::Selesai],
            ['id' => 'edukasi-diet', 'name' => 'Edukasi diet', 'status' => NursingActionStatus::DalamProses],
            ['id' => 'monitoring-drain', 'name' => 'Monitoring drain', 'status' => NursingActionStatus::Belum],
            ['id' => 'observasi-ttv', 'name' => 'Observasi TTV', 'status' => NursingActionStatus::Selesai],
            ['id' => 'kebersihan', 'name' => 'Kebersihan diri', 'status' => NursingActionStatus::Selesai],
            ['id' => 'konseling', 'name' => 'Konseling keluarga', 'status' => NursingActionStatus::DalamProses],
        ];
    }

    /**
     * @return list<string>
     */
    public static function nursingActionTypeOptions(): array
    {
        return [
            'Mobilisasi dini',
            'Edukasi diet',
            'Monitoring drain',
            'Observasi TTV',
            'Kebersihan diri',
            'Konseling keluarga',
        ];
    }

    /**
     * @return array<string, array{
     *     diagnosis: string,
     *     procedure: string,
     *     phase: string,
     *     dpjp: string,
     *     allergy: string,
     *     summary: list<string>
     * }>
     */
    public static function handoverDetailsBySlug(): array
    {
        $details = [];

        foreach (self::patients() as $patient) {
            $details[$patient['slug']] = [
                'diagnosis' => $patient['diagnosis'],
                'procedure' => $patient['procedure'],
                'phase' => $patient['phase']->label(),
                'dpjp' => 'dr. Andi Putra, Sp.B',
                'allergy' => $patient['slug'] === 'budi-santoso' ? '-' : 'Tidak diketahui',
                'summary' => [
                    'Tindakan terakhir: Mobilisasi dini',
                    'TTV terakhir: 120/80 mmHg | N 88 | RR 18 | SpO2 98%',
                    'Nyeri: Skala 3/10',
                    'Luka: Balutan bersih',
                    'Drain: Terpasang (50 ml)',
                    'Edukasi: Diet, mobilisasi, tanda bahaya',
                ],
            ];
        }

        return $details;
    }

    /**
     * @return list<array{
     *     patient_name: string,
     *     shift: string,
     *     nurse: string,
     *     locked_at: string,
     *     status: HandoverLockStatus
     * }>
     */
    public static function handoverHistory(): array
    {
        return [
            [
                'patient_name' => 'Tn. Budi Santoso',
                'shift' => 'Malam → Pagi',
                'nurse' => 'Ns. Rina Wulandari',
                'locked_at' => '23 Sep 2026 06:45',
                'status' => HandoverLockStatus::Terkunci,
            ],
            [
                'patient_name' => 'Ny. Siti Rahayu',
                'shift' => 'Siang → Malam',
                'nurse' => 'Ns. Made Suryani',
                'locked_at' => '22 Sep 2026 14:10',
                'status' => HandoverLockStatus::Terkunci,
            ],
        ];
    }

    /**
     * @return list<array{
     *     id: string,
     *     title: string,
     *     goal: string,
     *     intervention: string,
     *     status: CarePlanStatus
     * }>
     */
    public static function carePlanDiagnoses(string $slug): array
    {
        if ($slug !== 'budi-santoso') {
            return [
                [
                    'id' => 'd1',
                    'title' => 'Risiko infeksi berhubungan dengan prosedur invasif',
                    'goal' => 'Tidak terjadi infeksi selama perawatan',
                    'intervention' => 'Cuci tangan, aseptik, monitoring luka',
                    'status' => CarePlanStatus::Aktif,
                ],
            ];
        }

        return [
            [
                'id' => 'd1',
                'title' => 'Nyeri akut berhubungan dengan agen pencedera fisik',
                'goal' => 'Nyeri berkurang dalam 1x24 jam',
                'intervention' => 'Manajemen nyeri, posisi nyaman, teknik relaksasi',
                'status' => CarePlanStatus::Aktif,
            ],
            [
                'id' => 'd2',
                'title' => 'Risiko infeksi berhubungan dengan prosedur invasif',
                'goal' => 'Tidak terjadi infeksi luka operasi',
                'intervention' => 'Perawatan luka steril, observasi tanda infeksi',
                'status' => CarePlanStatus::Aktif,
            ],
            [
                'id' => 'd3',
                'title' => 'Defisit perawatan diri berhubungan dengan keterbatasan mobilitas',
                'goal' => 'Mandiri dalam ADL minimal dalam 3 hari',
                'intervention' => 'Bantuan bertahap, edukasi keluarga',
                'status' => CarePlanStatus::Aktif,
            ],
            [
                'id' => 'd4',
                'title' => 'Risiko jatuh berhubungan dengan kelemahan otot',
                'goal' => 'Tidak terjadi jatuh selama perawatan',
                'intervention' => 'Rail bed, orientasi lingkungan, mobilisasi aman',
                'status' => CarePlanStatus::Aktif,
            ],
        ];
    }

    /**
     * @return list<array{id: string, title: string, goal: string, intervention: string}>
     */
    public static function nursingDiagnosisMaster(): array
    {
        return [
            [
                'id' => 'm1',
                'title' => 'Nyeri akut berhubungan dengan agen pencedera fisik',
                'goal' => 'Nyeri berkurang dalam 1x24 jam',
                'intervention' => 'Manajemen nyeri, posisi nyaman, teknik relaksasi',
            ],
            [
                'id' => 'm2',
                'title' => 'Risiko infeksi berhubungan dengan prosedur invasif',
                'goal' => 'Tidak terjadi infeksi luka operasi',
                'intervention' => 'Perawatan luka steril, observasi tanda infeksi',
            ],
            [
                'id' => 'm3',
                'title' => 'Risiko jatuh berhubungan dengan kelemahan otot',
                'goal' => 'Tidak terjadi jatuh selama perawatan',
                'intervention' => 'Rail bed, orientasi lingkungan, mobilisasi aman',
            ],
        ];
    }

    /**
     * @return array{
     *     total: int,
     *     completed: int,
     *     pending: int,
     *     incidents: int
     * }
     */
    public static function reportSummary(): array
    {
        return [
            'total' => 32,
            'completed' => 28,
            'pending' => 4,
            'incidents' => 0,
        ];
    }

    /**
     * @return list<array{
     *     name: string,
     *     medical_record: string,
     *     diagnosis: string,
     *     nursing_diagnosis: string,
     *     status: NursingActionStatus
     * }>
     */
    public static function reportDetailRows(): array
    {
        return [
            [
                'name' => 'Tn. Budi Santoso',
                'medical_record' => '123456',
                'diagnosis' => 'Fraktur Femur',
                'nursing_diagnosis' => 'Nyeri akut',
                'status' => NursingActionStatus::Selesai,
            ],
            [
                'name' => 'Ny. Siti Aminah',
                'medical_record' => '123457',
                'diagnosis' => 'Ca. Colon',
                'nursing_diagnosis' => 'Risiko jatuh',
                'status' => NursingActionStatus::DalamProses,
            ],
            [
                'name' => 'Tn. Made Wijaya',
                'medical_record' => '123458',
                'diagnosis' => 'Appendektomi',
                'nursing_diagnosis' => 'Risiko infeksi',
                'status' => NursingActionStatus::Selesai,
            ],
        ];
    }

    /**
     * @return list<array{time: string, task: string, patient: string}>
     */
    public static function periodicMonitoring(): array
    {
        return [
            ['time' => '08:00', 'task' => 'Observasi TTV', 'patient' => 'Tn. Budi Santoso'],
            ['time' => '10:00', 'task' => 'Mobilisasi dini', 'patient' => 'Ny. Siti Rahayu'],
            ['time' => '12:00', 'task' => 'Monitoring drain', 'patient' => 'Tn. Made Wijaya'],
        ];
    }
}
