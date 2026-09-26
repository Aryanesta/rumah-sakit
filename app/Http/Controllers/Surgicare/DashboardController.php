<?php

namespace App\Http\Controllers\Surgicare;

use App\Http\Controllers\Controller;
use App\Support\Surgicare\SiapOperasi\GuideProgressRepository;
use App\Support\Surgicare\SurgicareDemoData;
use Illuminate\View\View;

final class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $todayPatients = array_map(function (array $row): array {
            $row['guide_warning'] = GuideProgressRepository::warningLevel($row['slug']);

            return $row;
        }, SurgicareDemoData::todayPatients());

        return view('apps.surgicare.dashboard', [
            'stats' => SurgicareDemoData::dashboardStats(),
            'todayPatients' => $todayPatients,
            'nurseName' => SurgicareDemoData::DEMO_NURSE_NAME,
        ]);
    }
}
