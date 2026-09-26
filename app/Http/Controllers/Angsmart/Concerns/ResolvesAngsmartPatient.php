<?php

namespace App\Http\Controllers\Angsmart\Concerns;

use App\Enums\Angsmart\NursingCareStatus;
use App\Enums\Angsmart\SurgicalPhase;
use App\Support\Angsmart\AngsmartDemoData;

trait ResolvesAngsmartPatient
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
     *     care_status: NursingCareStatus,
     *     procedure: string,
     *     needs_handover: bool
     * }
     */
    protected function resolveAngsmartPatient(string $patient): array
    {
        $record = AngsmartDemoData::findPatient($patient);

        if ($record === null) {
            abort(404);
        }

        return $record;
    }
}
