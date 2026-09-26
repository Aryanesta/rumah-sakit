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
        $nurse = User::factory()->nurse()->create();

        $this->actingAs($nurse)->get('/apps/surgicare')->assertOk();
        $this->actingAs($nurse)->get('/apps/angsmart')->assertOk();
        $this->actingAs($nurse)->get('/apps/ansafe')->assertOk();

        $patient = User::factory()->create([
            'email' => 'pasien@rumahsakit.com',
            'username' => 'pasien',
        ]);

        $this->actingAs($patient)->get('/apps/surgicare/siap-operasi')->assertOk();
    }

    public function test_guest_cannot_access_application_modules(): void
    {
        $this->get('/apps/surgicare')->assertRedirect('/login');
    }
}
