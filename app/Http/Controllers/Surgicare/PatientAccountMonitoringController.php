<?php

namespace App\Http\Controllers\Surgicare;

use App\Http\Controllers\Controller;
use App\Support\Surgicare\SiapOperasi\GuideProgressRepository;
use Illuminate\View\View;

final class PatientAccountMonitoringController extends Controller
{
    public function __invoke(): View
    {
        return view('apps.surgicare.monitoring.index', [
            'rows' => GuideProgressRepository::monitoringRows(),
        ]);
    }
}
