<?php

namespace Tests\Feature\Integration;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_patient_management(): void
    {
        $this->get('/integration/patients')->assertRedirect('/login');
    }

    public function test_nurse_can_access_patient_management(): void
    {
        $nurse = User::factory()->nurse()->create();

        $this->actingAs($nurse)->get('/integration/patients')->assertOk();
    }

    public function test_patient_cannot_access_patient_management(): void
    {
        $patient = User::factory()->patient()->create();

        $this->actingAs($patient)->get('/integration/patients')->assertForbidden();
    }
}
