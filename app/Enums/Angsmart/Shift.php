<?php

namespace App\Enums\Angsmart;

enum Shift: string
{
    case Pagi = 'pagi';
    case Siang = 'siang';
    case Malam = 'malam';

    public function label(): string
    {
        return match ($this) {
            self::Pagi => 'Pagi',
            self::Siang => 'Siang',
            self::Malam => 'Malam',
        };
    }
}
