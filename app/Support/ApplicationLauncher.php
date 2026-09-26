<?php

namespace App\Support;

use App\Enums\UserRole;
use App\Models\User;

final class ApplicationLauncher
{
    /**
     * @return list<array{key: string, label: string, route: string, icon: string, variant: 'primary'|'surface'|'muted'}>
     */
    public static function applicationsForUser(?User $user): array
    {
        if ($user !== null && $user->role instanceof UserRole && $user->role === UserRole::Patient) {
            return [
                [
                    'key' => 'siap-operasi',
                    'label' => 'SIAP OPERASI',
                    'route' => 'apps.surgicare.siap-operasi.index',
                    'icon' => 'surgicare',
                    'variant' => 'primary',
                ],
            ];
        }

        return self::applications();
    }

    /**
     * Registered hospital applications shown on the post-login launcher.
     *
     * @return list<array{key: string, label: string, route: string, icon: string, variant: 'primary'|'surface'|'muted'}>
     */
    public static function applications(): array
    {
        return [
            [
                'key' => 'surgicare',
                'label' => 'Surgicare',
                'route' => 'apps.surgicare.index',
                'icon' => 'surgicare',
                'variant' => 'primary',
            ],
            [
                'key' => 'angsmart',
                'label' => 'Angsmart',
                'route' => 'apps.angsmart.index',
                'icon' => 'angsmart',
                'variant' => 'muted',
            ],
            [
                'key' => 'ansafe',
                'label' => 'ANSafe',
                'route' => 'apps.ansafe.index',
                'icon' => 'ansafe',
                'variant' => 'surface',
            ],
            [
                'key' => 'patient-management',
                'label' => 'Manajemen Data Pasien',
                'route' => 'integration.patients.index',
                'icon' => 'patients',
                'variant' => 'surface',
            ],
        ];
    }
}
