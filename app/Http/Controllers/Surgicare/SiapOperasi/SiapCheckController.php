<?php

namespace App\Http\Controllers\Surgicare\SiapOperasi;

use App\Http\Controllers\Controller;
use App\Support\Surgicare\SiapOperasi\GuideProgressRepository;
use App\Support\Surgicare\SiapOperasi\PatientPortalIdentity;
use App\Support\Surgicare\SiapOperasi\SiapCheckContent;
use Illuminate\View\View;

final class SiapCheckController extends Controller
{
    public function __invoke(): View
    {
        $slug = PatientPortalIdentity::slugForUser();
        $progress = GuideProgressRepository::get($slug);

        return view('apps.surgicare.siap-operasi.siap-check', [
            'intro' => SiapCheckContent::intro(),
            'metaLabel' => SiapCheckContent::metaLabel(),
            'questions' => SiapCheckContent::questions(),
            'finalMessages' => SiapCheckContent::finalMessages(),
            'studiedMaterials' => SiapCheckContent::studiedMaterials(),
            'progress' => $progress,
            'submitUrl' => route('apps.surgicare.siap-operasi.siap-check.store'),
        ]);
    }
}
