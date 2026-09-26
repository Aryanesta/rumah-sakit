<?php

namespace App\Enums\Angsmart;

enum NursingCareStatus: string
{
    case DalamAsuhan = 'dalam_asuhan';
    case MenungguTindakan = 'menunggu_tindakan';

    public function label(): string
    {
        return match ($this) {
            self::DalamAsuhan => 'Dalam Asuhan',
            self::MenungguTindakan => 'Menunggu Tindakan',
        };
    }

    public function badgeTone(): string
    {
        return match ($this) {
            self::DalamAsuhan => 'success',
            self::MenungguTindakan => 'warning',
        };
    }
}
