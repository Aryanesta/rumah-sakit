<?php

namespace App\Http\Controllers\Angsmart;

use App\Http\Controllers\Controller;
use App\Support\Angsmart\AngsmartDemoData;
use App\Support\Ansafe\AnsafeDemoData;
use Illuminate\View\View;

final class PatientListController extends Controller
{
    public function __invoke(): View
    {
        $patients = array_map(function (array $patient): array {
            $ansafe = AnsafeDemoData::findPatient($patient['slug']);

            if ($ansafe !== null) {
                $patient['fall_risk'] = $ansafe['risk']->value;
            }

            return $patient;
        }, AngsmartDemoData::patientsForFrontend());

        return view('apps.angsmart.patients.index', [
            'patients' => $patients,
            'phaseOptions' => AngsmartDemoData::phaseFilterOptions(),
            'statusOptions' => AngsmartDemoData::careStatusFilterOptions(),
        ]);
    }
}
