<?php

namespace App\Http\Controllers\Surgicare\SiapOperasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Surgicare\SubmitSiapCheckRequest;
use App\Support\Surgicare\SiapOperasi\GuideProgressRepository;
use App\Support\Surgicare\SiapOperasi\PatientPortalIdentity;
use App\Support\Surgicare\SiapOperasi\SiapCheckContent;
use Illuminate\Http\JsonResponse;

final class SubmitSiapCheckController extends Controller
{
    public function __invoke(SubmitSiapCheckRequest $request): JsonResponse
    {
        $slug = PatientPortalIdentity::slugForUser();
        $progress = GuideProgressRepository::saveSiapCheck($slug, $request->answers());
        $total = count(SiapCheckContent::questions());
        $score = $progress['siap_check_score'] ?? 0;

        return response()->json([
            'ok' => true,
            'score' => $score,
            'total' => $total,
            'understanding_good' => $score === $total,
            'summary' => GuideProgressRepository::completionSummary($slug),
        ]);
    }
}
