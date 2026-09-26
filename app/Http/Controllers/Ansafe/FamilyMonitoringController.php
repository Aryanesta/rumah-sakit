<?php

namespace App\Http\Controllers\Ansafe;

use App\Http\Controllers\Ansafe\Concerns\ResolvesAnsafePatient;
use App\Http\Controllers\Controller;
use App\Support\Ansafe\AnsafeDemoData;
use Illuminate\View\View;

final class FamilyMonitoringController extends Controller
{
    use ResolvesAnsafePatient;

    public function __invoke(string $patient): View
    {
        $record = $this->resolvePatient($patient);

        return view('apps.ansafe.patients.family-monitoring', [
            'patient' => $record,
            'educationHistory' => AnsafeDemoData::educationHistory($patient),
            'teachBackRows' => AnsafeDemoData::teachBackMonitoring($patient),
        ]);
    }
}
