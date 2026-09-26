<?php

namespace App\Http\Controllers\Integration;

use App\Http\Controllers\Controller;
use App\Support\Integration\IntegrationPatientDemoData;
use Illuminate\View\View;

final class PatientManagementController extends Controller
{
    public function __invoke(): View
    {
        return view('integration.patients.index', [
            'patients' => IntegrationPatientDemoData::forFrontend(),
            'phaseOptions' => IntegrationPatientDemoData::phaseOptions(),
            'genderOptions' => IntegrationPatientDemoData::genderOptions(),
        ]);
    }
}
