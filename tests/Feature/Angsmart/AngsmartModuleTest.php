<?php

namespace Tests\Feature\Angsmart;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AngsmartModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_angsmart_dashboard(): void
    {
        $this->get('/apps/angsmart')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_angsmart_routes(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/apps/angsmart')->assertOk();
        $this->actingAs($user)->get('/apps/angsmart/patients')->assertOk();
        $this->actingAs($user)->get('/apps/angsmart/patients/budi-santoso/nursing-care')->assertOk();
        $this->actingAs($user)->get('/apps/angsmart/patients/budi-santoso/care-plan')->assertOk();
        $this->actingAs($user)->get('/apps/angsmart/handover')->assertOk();
        $this->actingAs($user)->get('/apps/angsmart/reports')->assertOk();
    }

    public function test_unknown_patient_returns_not_found_on_nursing_care(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/apps/angsmart/patients/tidak-ada/nursing-care')
            ->assertNotFound();
    }

    public function test_unknown_patient_returns_not_found_on_care_plan(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/apps/angsmart/patients/tidak-ada/care-plan')
            ->assertNotFound();
    }

    public function test_store_patient_demo_redirects_with_flash(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/apps/angsmart/patients', [
                'name' => 'Tn. Demo',
                'medical_record' => '999999',
                'bed' => '201',
                'diagnosis' => 'Demo',
                'phase' => 'post_op',
            ])
            ->assertRedirect(route('apps.angsmart.patients.index'))
            ->assertSessionHas('status', 'demo-patient-saved');
    }
}
