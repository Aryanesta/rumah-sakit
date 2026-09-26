<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppLauncherTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_app_launcher(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_open_each_application_route(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/apps/surgicon')->assertOk();
        $this->actingAs($user)->get('/apps/angsmart')->assertOk();
        $this->actingAs($user)->get('/apps/ansafe')->assertOk();
    }

    public function test_guest_cannot_access_application_modules(): void
    {
        $this->get('/apps/surgicon')->assertRedirect('/login');
    }
}
