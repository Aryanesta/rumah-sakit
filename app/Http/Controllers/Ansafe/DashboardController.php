<?php

namespace App\Http\Controllers\Ansafe;

use App\Http\Controllers\Controller;
use App\Support\Ansafe\AnsafeDemoData;
use Illuminate\View\View;

final class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('apps.ansafe.dashboard', [
            'stats' => AnsafeDemoData::dashboardStats(),
            'patients' => AnsafeDemoData::patientsForFrontend(),
            'highRiskPatients' => AnsafeDemoData::highRiskPatients(),
            'roomOptions' => AnsafeDemoData::roomFilterOptions(),
        ]);
    }
}
