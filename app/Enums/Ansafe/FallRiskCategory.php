<?php

namespace App\Enums\Ansafe;

enum FallRiskCategory: string
{
    case Rendah = 'rendah';
    case Sedang = 'sedang';
    case Tinggi = 'tinggi';

    public function label(): string
    {
        return match ($this) {
            self::Rendah => 'Rendah',
            self::Sedang => 'Sedang',
            self::Tinggi => 'Tinggi',
        };
    }

    public function badgeLabel(): string
    {
        return match ($this) {
            self::Rendah => 'Risiko Rendah',
            self::Sedang => 'Risiko Sedang',
            self::Tinggi => 'RISIKO TINGGI',
        };
    }
}
