<?php

namespace App\Http\Controllers\Angsmart;

use App\Http\Controllers\Controller;
use App\Support\Angsmart\AngsmartDemoData;
use Illuminate\View\View;

final class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('apps.angsmart.dashboard', [
            'stats' => AngsmartDemoData::dashboardStats(),
            'donut' => AngsmartDemoData::careStatusDonut(),
            'pendingPatients' => AngsmartDemoData::pendingActionPatients(),
        ]);
    }
}
