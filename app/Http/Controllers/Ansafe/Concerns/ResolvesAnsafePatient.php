<?php

namespace App\Http\Controllers\Ansafe\Concerns;

use App\Enums\Ansafe\FallRiskCategory;
use App\Support\Ansafe\AnsafeDemoData;

trait ResolvesAnsafePatient
{
    /**
     * @return array{
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
     * }
     */
    protected function resolvePatient(string $patient): array
    {
        $record = AnsafeDemoData::findPatient($patient);

        if ($record === null) {
            abort(404);
        }

        return $record;
    }
}
