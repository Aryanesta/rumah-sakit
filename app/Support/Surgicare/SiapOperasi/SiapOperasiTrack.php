<?php

namespace App\Support\Surgicare\SiapOperasi;

enum SiapOperasiTrack: string
{
    case Sebelum = 'sebelum';
    case Setelah = 'setelah';
    case Keluarga = 'keluarga';

    public function label(): string
    {
        return match ($this) {
            self::Sebelum => 'Sebelum Operasi',
            self::Setelah => 'Setelah Operasi',
            self::Keluarga => 'Untuk Keluarga',
        };
    }
}
