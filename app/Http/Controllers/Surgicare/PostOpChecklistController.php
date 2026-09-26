<?php

namespace App\Http\Controllers\Surgicare;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Surgicare\Concerns\ResolvesSurgicarePatient;
use App\Support\Surgicare\SurgicareDemoData;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class PostOpChecklistController extends Controller
{
    use ResolvesSurgicarePatient;

    public function __invoke(Request $request, string $patient): View
    {
        $record = $this->resolveSurgicarePatient($patient);

        $activeTab = $request->query('tab', 'checklist');
        if (! in_array($activeTab, ['data', 'checklist', 'catatan'], true)) {
            $activeTab = 'checklist';
        }

        return view('apps.surgicare.checklists.post-op', [
            'patient' => $record,
            'sections' => SurgicareDemoData::postOpChecklist($patient),
            'activeTab' => $activeTab,
        ]);
    }
}
