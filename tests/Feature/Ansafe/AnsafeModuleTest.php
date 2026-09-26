<?php

namespace Tests\Feature\Ansafe;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnsafeModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_ansafe_dashboard(): void
    {
        $this->get('/apps/ansafe')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_ansafe_routes(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/apps/ansafe')->assertOk();
        $this->actingAs($user)->get('/apps/ansafe/patients')->assertOk();
        $this->actingAs($user)->get('/apps/ansafe/patients/budi-santoso/assessment')->assertOk();
        $this->actingAs($user)->get('/apps/ansafe/education')->assertOk();
        $this->actingAs($user)->get('/apps/ansafe/patients/budi-santoso/family-monitoring')->assertOk();
    }

    public function test_unknown_patient_returns_not_found(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/apps/ansafe/patients/tidak-ada/assessment')
            ->assertNotFound();
    }
}
