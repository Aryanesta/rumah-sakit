<?php

namespace App\Http\Controllers\Angsmart;

use App\Http\Controllers\Angsmart\Concerns\ResolvesAngsmartPatient;
use App\Http\Controllers\Controller;
use App\Support\Angsmart\AngsmartDemoData;
use Illuminate\View\View;

final class NursingCareController extends Controller
{
    use ResolvesAngsmartPatient;

    public function __invoke(string $patient): View
    {
        $record = $this->resolveAngsmartPatient($patient);

        return view('apps.angsmart.nursing-care.show', [
            'patient' => $record,
            'actions' => AngsmartDemoData::nursingActionsFor($patient),
            'actionTypes' => AngsmartDemoData::nursingActionTypeOptions(),
            'activeTab' => request()->query('tab', 'input'),
        ]);
    }
}
