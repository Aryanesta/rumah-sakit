<?php

namespace App\Http\Controllers\Surgicare\SiapOperasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Surgicare\SaveGuideChecklistRequest;
use App\Support\Surgicare\SiapOperasi\GuideProgressRepository;
use App\Support\Surgicare\SiapOperasi\PatientPortalIdentity;
use Illuminate\Http\JsonResponse;

final class SaveGuideChecklistController extends Controller
{
    public function __invoke(SaveGuideChecklistRequest $request): JsonResponse
    {
        $slug = PatientPortalIdentity::slugForUser();

        $progress = GuideProgressRepository::setChecklistItem(
            $slug,
            $request->track(),
            $request->validated('item_id'),
            $request->boolean('checked'),
        );

        return response()->json([
            'ok' => true,
            'summary' => GuideProgressRepository::completionSummary($slug),
            'pre_op_completed_at' => $progress['pre_op_completed_at'],
            'post_op_completed_at' => $progress['post_op_completed_at'],
            'family_completed_at' => $progress['family_completed_at'],
        ]);
    }
}
