<?php

namespace App\Http\Controllers\Surgicare\SiapOperasi;

use App\Http\Controllers\Controller;
use App\Support\Surgicare\SiapOperasi\GuideProgressRepository;
use App\Support\Surgicare\SiapOperasi\PatientPortalIdentity;
use App\Support\Surgicare\SiapOperasi\SetelahOperasiContent;
use App\Support\Surgicare\SiapOperasi\SiapOperasiTrack;
use Illuminate\View\View;

final class SetelahOperasiController extends Controller
{
    public function __invoke(): View
    {
        $slug = PatientPortalIdentity::slugForUser();
        $page = SetelahOperasiContent::page();
        $progress = GuideProgressRepository::get($slug);

        return view('apps.surgicare.siap-operasi.setelah-operasi', [
            'page' => $page,
            'track' => SiapOperasiTrack::Setelah->value,
            'progress' => $progress,
            'checklistSaveUrl' => route('apps.surgicare.siap-operasi.checklist.store'),
        ]);
    }
}
