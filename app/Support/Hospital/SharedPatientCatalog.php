<?php

namespace App\Support\Hospital;

final class SharedPatientCatalog
{
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
    public static function corePatients(): array
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
            ],
            [
                'slug' => 'siti-rahayu',
                'name' => 'Ny. Siti Rahayu',
                'medical_record' => '123457',
                'age' => 54,
                'room' => 'Angsoka 1',
                'bed' => '105',
                'diagnosis' => 'Stroke',
            ],
            [
                'slug' => 'made-wijaya',
                'name' => 'Tn. Made Wijaya',
                'medical_record' => '123458',
                'age' => 42,
                'room' => 'Angsoka 2',
                'bed' => '201',
                'diagnosis' => 'Appendektomi',
            ],
            [
                'slug' => 'dewi-kartika',
                'name' => 'Ny. Dewi Kartika',
                'medical_record' => '123459',
                'age' => 71,
                'room' => 'Angsoka 1',
                'bed' => '108',
                'diagnosis' => 'Hipertensi',
            ],
            [
                'slug' => 'agus-pratama',
                'name' => 'Tn. Agus Pratama',
                'medical_record' => '123460',
                'age' => 58,
                'room' => 'Angsoka 2',
                'bed' => '203',
                'diagnosis' => 'Diabetes Melitus',
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
     *     diagnosis: string
     * }>
     */
    public static function corePatientsBySlug(): array
    {
        $indexed = [];

        foreach (self::corePatients() as $patient) {
            $indexed[$patient['slug']] = $patient;
        }

        return $indexed;
    }

    /**
     * @return array{
     *     slug: string,
     *     name: string,
     *     medical_record: string,
     *     age: int,
     *     room: string,
     *     bed: string,
     *     diagnosis: string
     * }|null
     */
    public static function findCorePatient(string $slug): ?array
    {
        return self::corePatientsBySlug()[$slug] ?? null;
    }
}
