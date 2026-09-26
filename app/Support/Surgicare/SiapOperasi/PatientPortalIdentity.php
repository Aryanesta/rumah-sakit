<?php

namespace App\Support\Surgicare\SiapOperasi;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Maps authenticated demo users to Surgicare patient slugs until users.patient_slug exists.
 */
final class PatientPortalIdentity
{
    /**
     * @var array<string, string>
     */
    private const USERNAME_TO_SLUG = [
        'pasien' => 'budi-santoso',
        'testuser' => 'sari-dewi',
    ];

    /**
     * @var array<string, string>
     */
    private const EMAIL_TO_SLUG = [
        'pasien@rumahsakit.com' => 'budi-santoso',
        'test@example.com' => 'sari-dewi',
    ];

    public static function slugForUser(?User $user = null): string
    {
        $user ??= Auth::user();

        if ($user === null || ! ($user->role instanceof UserRole) || $user->role !== UserRole::Patient) {
            abort(403);
        }

        if ($user->username !== null && isset(self::USERNAME_TO_SLUG[$user->username])) {
            return self::USERNAME_TO_SLUG[$user->username];
        }

        if (isset(self::EMAIL_TO_SLUG[$user->email])) {
            return self::EMAIL_TO_SLUG[$user->email];
        }

        abort(403);
    }
}
