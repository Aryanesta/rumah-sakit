<?php

namespace App\Http\Controllers\Surgicare\SiapOperasi;

use App\Http\Controllers\Controller;
use App\Support\Surgicare\SiapOperasi\GuideProgressRepository;
use App\Support\Surgicare\SiapOperasi\PatientPortalIdentity;
use App\Support\Surgicare\SiapOperasi\SiapOperasiDashboardContent;
use Illuminate\View\View;

final class SiapOperasiDashboardController extends Controller
{
    public function __invoke(): View
    {
        $slug = PatientPortalIdentity::slugForUser();
        $summary = GuideProgressRepository::completionSummary($slug);

        return view('apps.surgicare.siap-operasi.dashboard', [
            'content' => SiapOperasiDashboardContent::page(),
            'summary' => $summary,
        ]);
    }
}
