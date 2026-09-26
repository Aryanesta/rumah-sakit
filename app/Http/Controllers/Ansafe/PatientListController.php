<?php

namespace App\Http\Controllers\Ansafe;

use App\Http\Controllers\Controller;
use App\Support\Ansafe\AnsafeDemoData;
use Illuminate\View\View;

final class PatientListController extends Controller
{
    public function __invoke(): View
    {
        return view('apps.ansafe.patients.index', [
            'patients' => AnsafeDemoData::patientsForFrontend(),
            'roomOptions' => AnsafeDemoData::roomFilterOptions(),
        ]);
    }
}
