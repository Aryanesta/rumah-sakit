<?php

namespace App\Http\Controllers\Surgicare\Concerns;

use App\Enums\Angsmart\SurgicalPhase;
use App\Support\Surgicare\SurgicareDemoData;

trait ResolvesSurgicarePatient
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
     *     phase: SurgicalPhase,
     *     procedure: string,
     *     checklist_status: string,
     *     checklist_status_tone: string
     * }
     */
    protected function resolveSurgicarePatient(string $patient): array
    {
        $record = SurgicareDemoData::findPatient($patient);

        if ($record === null) {
            abort(404);
        }

        return $record;
    }
}
