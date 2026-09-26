<?php

namespace App\Http\Controllers\Surgicare\SiapOperasi;

use App\Http\Controllers\Controller;
use App\Support\Surgicare\SiapOperasi\GuideProgressRepository;
use App\Support\Surgicare\SiapOperasi\PatientPortalIdentity;
use App\Support\Surgicare\SiapOperasi\SiapOperasiTrack;
use App\Support\Surgicare\SiapOperasi\UntukKeluargaContent;
use Illuminate\View\View;

final class UntukKeluargaController extends Controller
{
    public function __invoke(): View
    {
        $slug = PatientPortalIdentity::slugForUser();
        $page = UntukKeluargaContent::page();
        $progress = GuideProgressRepository::get($slug);

        return view('apps.surgicare.siap-operasi.keluarga', [
            'page' => $page,
            'track' => SiapOperasiTrack::Keluarga->value,
            'progress' => $progress,
            'checklistSaveUrl' => route('apps.surgicare.siap-operasi.checklist.store'),
        ]);
    }
}
