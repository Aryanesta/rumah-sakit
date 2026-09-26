<?php

namespace App\Support\Integration;

use App\Support\Hospital\SharedPatientCatalog;
use Illuminate\Support\Carbon;

final class IntegrationPatientDemoData
{
    /**
     * @return list<array{value: string, label: string}>
     */
    public static function phaseOptions(): array
    {
        return [
            ['value' => 'PRE_OP', 'label' => 'Pre-Op'],
            ['value' => 'INTRA_OP', 'label' => 'Intra-Op'],
            ['value' => 'POST_OP', 'label' => 'Post-Op'],
            ['value' => 'INPATIENT_CARE', 'label' => 'Rawat Inap'],
            ['value' => 'DISCHARGED', 'label' => 'Pulang'],
        ];
    }

    /**
     * @return list<array{value: string, label: string}>
     */
    public static function genderOptions(): array
    {
        return [
            ['value' => 'M', 'label' => 'Laki-laki'],
            ['value' => 'F', 'label' => 'Perempuan'],
        ];
    }

    /**
     * @return list<array{
     *     id: string,
     *     name: string,
     *     medical_record: string,
     *     room_bed: string,
     *     date_of_birth: string,
     *     gender: string,
     *     phase_status: string
     * }>
     */
    public static function forFrontend(): array
    {
        $phaseBySlug = [
            'budi-santoso' => 'PRE_OP',
            'siti-rahayu' => 'INPATIENT_CARE',
            'made-wijaya' => 'POST_OP',
            'dewi-kartika' => 'INPATIENT_CARE',
            'agus-pratama' => 'DISCHARGED',
        ];

        $genderBySlug = [
            'budi-santoso' => 'M',
            'siti-rahayu' => 'F',
            'made-wijaya' => 'M',
            'dewi-kartika' => 'F',
            'agus-pratama' => 'M',
        ];

        $rows = [];

        foreach (SharedPatientCatalog::corePatients() as $patient) {
            $slug = $patient['slug'];
            $age = $patient['age'];
            $dateOfBirth = Carbon::now()->subYears($age)->startOfYear()->format('Y-m-d');

            $rows[] = [
                'id' => $slug,
                'name' => $patient['name'],
                'medical_record' => $patient['medical_record'],
                'room_bed' => $patient['room'].' / '.$patient['bed'],
                'date_of_birth' => $dateOfBirth,
                'gender' => $genderBySlug[$slug] ?? 'M',
                'phase_status' => $phaseBySlug[$slug] ?? 'PRE_OP',
            ];
        }

        return $rows;
    }
}
