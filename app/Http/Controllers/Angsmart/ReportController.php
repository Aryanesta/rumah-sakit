<?php

namespace App\Http\Controllers\Angsmart;

use App\Http\Controllers\Controller;
use App\Support\Angsmart\AngsmartDemoData;
use Illuminate\View\View;

final class ReportController extends Controller
{
    public function __invoke(): View
    {
        $detailRows = array_map(function (array $row): array {
            $row['status'] = $row['status']->value;

            return $row;
        }, AngsmartDemoData::reportDetailRows());

        return view('apps.angsmart.reports.index', [
            'summary' => AngsmartDemoData::reportSummary(),
            'detailRows' => $detailRows,
            'monitoring' => AngsmartDemoData::periodicMonitoring(),
            'activeTab' => request()->query('tab', 'laporan'),
        ]);
    }
}
