<?php

namespace App\Enums\Angsmart;

enum NursingActionStatus: string
{
    case Selesai = 'selesai';
    case DalamProses = 'dalam_proses';
    case Belum = 'belum';

    public function label(): string
    {
        return match ($this) {
            self::Selesai => 'Selesai',
            self::DalamProses => 'Dalam Proses',
            self::Belum => 'Belum',
        };
    }

    public function badgeTone(): string
    {
        return match ($this) {
            self::Selesai => 'success',
            self::DalamProses => 'warning',
            self::Belum => 'emergency',
        };
    }
}
