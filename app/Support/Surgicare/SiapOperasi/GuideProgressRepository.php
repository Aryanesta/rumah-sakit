<?php

namespace App\Support\Surgicare\SiapOperasi;

use App\Support\Surgicare\SurgicareDemoData;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

final class GuideProgressRepository
{
    private const CACHE_PREFIX = 'surgicare.guide_progress.';

    private const TTL_SECONDS = 60 * 60 * 24 * 30;

    /**
     * @return array{
     *     checklists: array<string, array<string, bool>>,
     *     pre_op_completed_at: string|null,
     *     post_op_completed_at: string|null,
     *     family_completed_at: string|null,
     *     siap_check_completed_at: string|null,
     *     siap_check_answers: array<string, string>,
     *     siap_check_score: int|null,
     *     family_question_notes: string|null
     * }
     */
    public static function get(string $slug): array
    {
        return Cache::remember(self::cacheKey($slug), self::TTL_SECONDS, fn (): array => self::emptyProgress($slug));
    }

    public static function setChecklistItem(string $slug, SiapOperasiTrack $track, string $itemId, bool $checked): array
    {
        $progress = self::get($slug);
        $validIds = self::itemIdsForTrack($track);

        if (! in_array($itemId, $validIds, true)) {
            abort(422, 'Invalid checklist item.');
        }

        $trackKey = $track->value;
        $progress['checklists'][$trackKey][$itemId] = $checked;

        self::refreshCompletionTimestamps($slug, $progress);

        Cache::put(self::cacheKey($slug), $progress, self::TTL_SECONDS);

        return $progress;
    }

    /**
     * @param  array<string, string>  $answers
     */
    public static function saveSiapCheck(string $slug, array $answers): array
    {
        $progress = self::get($slug);
        $score = 0;
        $total = count(SiapCheckContent::questions());

        foreach (SiapCheckContent::questions() as $question) {
            $given = $answers[$question['id']] ?? '';
            if ($given === $question['correct']) {
                $score++;
            }
        }

        $progress['siap_check_answers'] = $answers;
        $progress['siap_check_score'] = $score;
        $progress['siap_check_completed_at'] = now()->toIso8601String();

        Cache::put(self::cacheKey($slug), $progress, self::TTL_SECONDS);

        return $progress;
    }

    public static function saveFamilyQuestionNotes(string $slug, string $notes): array
    {
        $progress = self::get($slug);
        $progress['family_question_notes'] = $notes;
        Cache::put(self::cacheKey($slug), $progress, self::TTL_SECONDS);

        return $progress;
    }

    /**
     * @return array{
     *     pre_op_complete: bool,
     *     post_op_complete: bool,
     *     family_complete: bool,
     *     siap_check_complete: bool,
     *     siap_check_good: bool
     * }
     */
    public static function completionSummary(string $slug): array
    {
        $progress = self::get($slug);
        $totalQuestions = count(SiapCheckContent::questions());
        $score = $progress['siap_check_score'] ?? 0;

        return [
            'pre_op_complete' => $progress['pre_op_completed_at'] !== null,
            'post_op_complete' => $progress['post_op_completed_at'] !== null,
            'family_complete' => $progress['family_completed_at'] !== null,
            'siap_check_complete' => $progress['siap_check_completed_at'] !== null,
            'siap_check_good' => $totalQuestions > 0 && $score === $totalQuestions,
        ];
    }

    public static function countPreOpGuideComplete(): int
    {
        $count = 0;

        foreach (SurgicareDemoData::patients() as $patient) {
            if (self::completionSummary($patient['slug'])['pre_op_complete']) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * @return list<array{
     *     slug: string,
     *     name: string,
     *     medical_record: string,
     *     pre_op_status: string,
     *     pre_op_at: string|null,
     *     post_op_status: string,
     *     post_op_at: string|null,
     *     warning_level: string|null
     * }>
     */
    public static function monitoringRows(): array
    {
        $rows = [];

        foreach (SurgicareDemoData::patients() as $patient) {
            $slug = $patient['slug'];
            $progress = self::get($slug);
            $rows[] = [
                'slug' => $slug,
                'name' => $patient['name'],
                'medical_record' => $patient['medical_record'],
                'pre_op_status' => $progress['pre_op_completed_at'] ? 'Sudah' : 'Belum',
                'pre_op_at' => self::formatTimestamp($progress['pre_op_completed_at']),
                'post_op_status' => $progress['post_op_completed_at'] ? 'Sudah' : 'Belum',
                'post_op_at' => self::formatTimestamp($progress['post_op_completed_at']),
                'warning_level' => self::warningLevel($slug),
            ];
        }

        return $rows;
    }

    public static function guideStatusLabel(string $slug): string
    {
        $summary = self::completionSummary($slug);

        if ($summary['pre_op_complete'] && $summary['post_op_complete']) {
            return 'Pre & Post selesai';
        }

        if ($summary['pre_op_complete']) {
            return 'Pre-Op selesai';
        }

        if ($summary['post_op_complete']) {
            return 'Post-Op selesai';
        }

        return 'Belum selesai';
    }

    public static function guideStatusTone(string $slug): string
    {
        $summary = self::completionSummary($slug);

        if ($summary['pre_op_complete'] || $summary['post_op_complete']) {
            return 'success';
        }

        return 'warning';
    }

    public static function warningLevel(string $slug): ?string
    {
        $progress = self::get($slug);

        if ($progress['pre_op_completed_at'] !== null) {
            return null;
        }

        $surgeryAt = SurgicareDemoData::scheduledSurgeryAt($slug);

        if ($surgeryAt === null) {
            return null;
        }

        $minutes = now()->diffInMinutes($surgeryAt, false);

        if ($minutes < 0 || $minutes > 120) {
            return null;
        }

        return $minutes <= 60 ? 'red' : 'yellow';
    }

    public static function forget(string $slug): void
    {
        Cache::forget(self::cacheKey($slug));
    }

    /**
     * @param  array<string, mixed>  $progress
     */
    private static function refreshCompletionTimestamps(string $slug, array &$progress): void
    {
        if (self::masterComplete($progress, SiapOperasiTrack::Sebelum, SebelumOperasiContent::masterChecklistItemIds())) {
            $progress['pre_op_completed_at'] ??= now()->toIso8601String();
        }

        if (self::masterComplete($progress, SiapOperasiTrack::Setelah, SetelahOperasiContent::masterChecklistItemIds())) {
            $progress['post_op_completed_at'] ??= now()->toIso8601String();
        }

        if (self::masterComplete($progress, SiapOperasiTrack::Keluarga, UntukKeluargaContent::masterChecklistItemIds())) {
            $progress['family_completed_at'] ??= now()->toIso8601String();
        }
    }

    /**
     * @param  array<string, mixed>  $progress
     * @param  list<string>  $masterIds
     */
    private static function masterComplete(array $progress, SiapOperasiTrack $track, array $masterIds): bool
    {
        if ($masterIds === []) {
            return false;
        }

        $trackItems = $progress['checklists'][$track->value] ?? [];

        foreach ($masterIds as $id) {
            if (empty($trackItems[$id])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return list<string>
     */
    private static function itemIdsForTrack(SiapOperasiTrack $track): array
    {
        return match ($track) {
            SiapOperasiTrack::Sebelum => SebelumOperasiContent::allChecklistItemIds(),
            SiapOperasiTrack::Setelah => SetelahOperasiContent::allChecklistItemIds(),
            SiapOperasiTrack::Keluarga => UntukKeluargaContent::allChecklistItemIds(),
        };
    }

    /**
     * @return array{
     *     checklists: array<string, array<string, bool>>,
     *     pre_op_completed_at: null,
     *     post_op_completed_at: null,
     *     family_completed_at: null,
     *     siap_check_completed_at: null,
     *     siap_check_answers: array<string, string>,
     *     siap_check_score: null,
     *     family_question_notes: null
     * }
     */
    private static function emptyProgress(string $slug): array
    {
        return [
            'checklists' => [
                SiapOperasiTrack::Sebelum->value => self::emptyItems(SebelumOperasiContent::allChecklistItemIds()),
                SiapOperasiTrack::Setelah->value => self::emptyItems(SetelahOperasiContent::allChecklistItemIds()),
                SiapOperasiTrack::Keluarga->value => self::emptyItems(UntukKeluargaContent::allChecklistItemIds()),
            ],
            'pre_op_completed_at' => null,
            'post_op_completed_at' => null,
            'family_completed_at' => null,
            'siap_check_completed_at' => null,
            'siap_check_answers' => [],
            'siap_check_score' => null,
            'family_question_notes' => null,
        ];
    }

    /**
     * @param  list<string>  $ids
     * @return array<string, bool>
     */
    private static function emptyItems(array $ids): array
    {
        $items = [];
        foreach ($ids as $id) {
            $items[$id] = false;
        }

        return $items;
    }

    private static function cacheKey(string $slug): string
    {
        return self::CACHE_PREFIX.$slug;
    }

    private static function formatTimestamp(?string $iso): ?string
    {
        if ($iso === null) {
            return null;
        }

        return Carbon::parse($iso)->timezone(config('app.timezone'))->format('d M Y H:i');
    }
}
