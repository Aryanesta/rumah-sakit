<?php

namespace Tests\Unit\Support;

use App\Models\User;
use App\Support\TimeGreeting;
use Carbon\Carbon;
use Tests\TestCase;

class TimeGreetingTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_for_user_uses_pagi_in_morning_wib(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-01-15 08:30:00', 'Asia/Jakarta'));

        $user = User::factory()->make(['name' => 'Budi']);

        $this->assertSame('Selamat pagi, Budi', TimeGreeting::forUser($user));
    }

    public function test_for_user_uses_siang_at_midday_wib(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-01-15 12:00:00', 'Asia/Jakarta'));

        $user = User::factory()->make(['name' => 'Ani']);

        $this->assertSame('Selamat siang, Ani', TimeGreeting::forUser($user));
    }

    public function test_for_user_uses_sore_in_afternoon_wib(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-01-15 16:45:00', 'Asia/Jakarta'));

        $user = User::factory()->make(['name' => 'Rina']);

        $this->assertSame('Selamat sore, Rina', TimeGreeting::forUser($user));
    }

    public function test_for_user_uses_malam_at_night_wib(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-01-15 22:00:00', 'Asia/Jakarta'));

        $user = User::factory()->make(['name' => 'Dewi']);

        $this->assertSame('Selamat malam, Dewi', TimeGreeting::forUser($user));
    }

    public function test_period_boundaries(): void
    {
        $this->assertSame('malam', TimeGreeting::periodLabel(Carbon::parse('2026-01-15 04:59:00', 'Asia/Jakarta')));
        $this->assertSame('pagi', TimeGreeting::periodLabel(Carbon::parse('2026-01-15 05:00:00', 'Asia/Jakarta')));
        $this->assertSame('pagi', TimeGreeting::periodLabel(Carbon::parse('2026-01-15 10:59:00', 'Asia/Jakarta')));
        $this->assertSame('siang', TimeGreeting::periodLabel(Carbon::parse('2026-01-15 11:00:00', 'Asia/Jakarta')));
        $this->assertSame('sore', TimeGreeting::periodLabel(Carbon::parse('2026-01-15 15:00:00', 'Asia/Jakarta')));
        $this->assertSame('sore', TimeGreeting::periodLabel(Carbon::parse('2026-01-15 18:59:00', 'Asia/Jakarta')));
        $this->assertSame('malam', TimeGreeting::periodLabel(Carbon::parse('2026-01-15 19:00:00', 'Asia/Jakarta')));
    }
}
