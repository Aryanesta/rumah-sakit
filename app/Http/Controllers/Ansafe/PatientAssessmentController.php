<?php

namespace App\Http\Controllers\Ansafe;

use App\Http\Controllers\Ansafe\Concerns\ResolvesAnsafePatient;
use App\Http\Controllers\Controller;
use App\Support\Ansafe\MorseFallScale;
use Illuminate\View\View;

final class PatientAssessmentController extends Controller
{
    use ResolvesAnsafePatient;

    public function __invoke(string $patient): View
    {
        $record = $this->resolvePatient($patient);
        $points = MorseFallScale::pointsForSelections($record['mfs_selections']);
        $total = MorseFallScale::total($points);
        $category = MorseFallScale::category($total);

        return view('apps.ansafe.patients.assessment', [
            'patient' => $record,
            'dimensions' => MorseFallScale::dimensions(),
            'selections' => $record['mfs_selections'],
            'initialTotal' => $total,
            'initialCategory' => $category->value,
            'protocolMessage' => MorseFallScale::protocolMessage($category),
        ]);
    }
}
