<?php

namespace Tests\Feature\Surgicare;

use App\Models\User;
use App\Support\Surgicare\SurgicareDemoData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SurgicareModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_surgicare_dashboard(): void
    {
        $this->get('/apps/surgicare')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_surgicare_routes(): void
    {
        $user = User::factory()->nurse()->create();

        $this->actingAs($user)->get('/apps/surgicare')->assertOk();
        $this->actingAs($user)->get('/apps/surgicare/patients')->assertOk();
        $this->actingAs($user)->get('/apps/surgicare/monitoring')->assertOk();
        $this->actingAs($user)
            ->get('/apps/surgicare/patients/'.SurgicareDemoData::DEFAULT_PRE_OP_SLUG.'/pre-op-checklist')
            ->assertOk();
        $this->actingAs($user)
            ->get('/apps/surgicare/patients/'.SurgicareDemoData::DEFAULT_POST_OP_SLUG.'/post-op-checklist')
            ->assertOk();
    }

    public function test_unknown_patient_returns_not_found_on_pre_op_checklist(): void
    {
        $user = User::factory()->nurse()->create();

        $this->actingAs($user)
            ->get('/apps/surgicare/patients/tidak-ada/pre-op-checklist')
            ->assertNotFound();
    }

    public function test_unknown_patient_returns_not_found_on_post_op_checklist(): void
    {
        $user = User::factory()->nurse()->create();

        $this->actingAs($user)
            ->get('/apps/surgicare/patients/tidak-ada/post-op-checklist')
            ->assertNotFound();
    }
}
