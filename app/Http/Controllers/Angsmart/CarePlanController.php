<?php

namespace App\Http\Controllers\Angsmart;

use App\Http\Controllers\Angsmart\Concerns\ResolvesAngsmartPatient;
use App\Http\Controllers\Controller;
use App\Support\Angsmart\AngsmartDemoData;
use Illuminate\View\View;

final class CarePlanController extends Controller
{
    use ResolvesAngsmartPatient;

    public function __invoke(string $patient): View
    {
        $record = $this->resolveAngsmartPatient($patient);

        return view('apps.angsmart.care-plan.show', [
            'patient' => $record,
            'diagnoses' => AngsmartDemoData::carePlanDiagnoses($patient),
            'masterDiagnoses' => AngsmartDemoData::nursingDiagnosisMaster(),
            'activeTab' => request()->query('tab', 'diagnosa'),
        ]);
    }
}
