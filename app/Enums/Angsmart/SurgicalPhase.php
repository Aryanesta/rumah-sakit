<?php

namespace App\Enums\Angsmart;

enum SurgicalPhase: string
{
    case PreOp = 'pre_op';
    case PostOp = 'post_op';

    public function label(): string
    {
        return match ($this) {
            self::PreOp => 'Pre-Op',
            self::PostOp => 'Post-Op',
        };
    }

    public function badgeTone(): string
    {
        return match ($this) {
            self::PreOp => 'info',
            self::PostOp => 'purple',
        };
    }
}
