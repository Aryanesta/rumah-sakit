<?php

namespace App\Http\Controllers\Surgicare;

use App\Http\Controllers\Controller;
use App\Support\Surgicare\SiapOperasi\GuideProgressRepository;
use App\Support\Surgicare\SurgicareDemoData;
use Illuminate\View\View;

final class PatientListController extends Controller
{
    public function __invoke(): View
    {
        $patients = array_map(function (array $patient): array {
            $patient['guide_status'] = GuideProgressRepository::guideStatusLabel($patient['slug']);
            $patient['guide_status_tone'] = GuideProgressRepository::guideStatusTone($patient['slug']);
            $patient['guide_warning'] = GuideProgressRepository::warningLevel($patient['slug']);

            return $patient;
        }, SurgicareDemoData::patientsForFrontend());

        return view('apps.surgicare.patients.index', [
            'patients' => $patients,
            'phaseOptions' => SurgicareDemoData::phaseFilterOptions(),
        ]);
    }
}
