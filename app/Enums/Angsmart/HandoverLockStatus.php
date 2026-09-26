<?php

namespace App\Enums\Angsmart;

enum HandoverLockStatus: string
{
    case Draft = 'draft';
    case Terkunci = 'terkunci';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Terkunci => 'Terkunci',
        };
    }
}
