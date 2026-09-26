<?php

namespace App\Support;

final class ApplicationLauncher
{
    /**
     * Registered hospital applications shown on the post-login launcher.
     *
     * @return list<array{key: string, label: string, route: string, icon: string, variant: 'primary'|'surface'|'muted'}>
     */
    public static function applications(): array
    {
        return [
            [
                'key' => 'surgicon',
                'label' => 'Surgicon',
                'route' => 'apps.surgicon.index',
                'icon' => 'surgicon',
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
        ];
    }
}
