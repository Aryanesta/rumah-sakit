<?php

namespace App\Http\Controllers\Angsmart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Angsmart\StorePatientRequest;
use Illuminate\Http\RedirectResponse;

final class StorePatientController extends Controller
{
    public function __invoke(StorePatientRequest $request): RedirectResponse
    {
        return redirect()
            ->route('apps.angsmart.patients.index')
            ->with('status', 'demo-patient-saved');
    }
}
