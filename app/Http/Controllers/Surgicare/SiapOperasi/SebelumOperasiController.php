<?php

namespace App\Http\Controllers\Surgicare\SiapOperasi;

use App\Http\Controllers\Controller;
use App\Support\Surgicare\SiapOperasi\GuideProgressRepository;
use App\Support\Surgicare\SiapOperasi\PatientPortalIdentity;
use App\Support\Surgicare\SiapOperasi\SebelumOperasiContent;
use App\Support\Surgicare\SiapOperasi\SiapOperasiTrack;
use Illuminate\View\View;

final class SebelumOperasiController extends Controller
{
    public function __invoke(): View
    {
        $slug = PatientPortalIdentity::slugForUser();
        $page = SebelumOperasiContent::page();
        $progress = GuideProgressRepository::get($slug);

        return view('apps.surgicare.siap-operasi.sebelum-operasi', [
            'page' => $page,
            'track' => SiapOperasiTrack::Sebelum->value,
            'progress' => $progress,
            'checklistSaveUrl' => route('apps.surgicare.siap-operasi.checklist.store'),
        ]);
    }
}
