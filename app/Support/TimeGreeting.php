<?php

namespace App\Support;

use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterface;

final class TimeGreeting
{
    /**
     * Indonesian time-of-day greeting for the launcher (WIB / Asia/Jakarta).
     *
     * Buckets:
     * - pagi — 05:00–10:59
     * - siang — 11:00–14:59
     * - sore — 15:00–18:59
     * - malam — otherwise
     */
    public static function forUser(User $user, ?CarbonInterface $at = null): string
    {
        $period = self::periodLabel($at ?? Carbon::now('Asia/Jakarta'));

        return "Selamat {$period}, {$user->name}";
    }

    public static function periodLabel(CarbonInterface $at): string
    {
        $hour = (int) $at->copy()->timezone('Asia/Jakarta')->format('G');

        if ($hour >= 5 && $hour <= 10) {
            return 'pagi';
        }

        if ($hour >= 11 && $hour <= 14) {
            return 'siang';
        }

        if ($hour >= 15 && $hour <= 18) {
            return 'sore';
        }

        return 'malam';
    }
}
