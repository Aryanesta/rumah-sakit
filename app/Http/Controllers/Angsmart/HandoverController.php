<?php

namespace App\Http\Controllers\Angsmart;

use App\Http\Controllers\Controller;
use App\Support\Angsmart\AngsmartDemoData;
use Illuminate\View\View;

final class HandoverController extends Controller
{
    public function __invoke(): View
    {
        $patients = AngsmartDemoData::patients();
        $defaultSlug = $patients[0]['slug'] ?? 'budi-santoso';

        return view('apps.angsmart.handover.index', [
            'patients' => $patients,
            'handoverDetails' => AngsmartDemoData::handoverDetailsBySlug(),
            'handoverHistory' => AngsmartDemoData::handoverHistory(),
            'defaultPatientSlug' => request()->query('patient', $defaultSlug),
            'activeTab' => request()->query('tab', 'handover'),
        ]);
    }
}
