<?php

namespace Tests\Feature\Surgicare;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SurgicareRoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_cannot_access_nurse_surgicare_routes(): void
    {
        $patient = User::factory()->create([
            'email' => 'pasien@rumahsakit.com',
            'username' => 'pasien',
        ]);

        $this->actingAs($patient)->get('/apps/surgicare/patients')->assertForbidden();
        $this->actingAs($patient)->get('/apps/surgicare/monitoring')->assertForbidden();
    }

    public function test_nurse_cannot_access_patient_siap_operasi_routes(): void
    {
        $nurse = User::factory()->nurse()->create();

        $this->actingAs($nurse)->get('/apps/surgicare/siap-operasi')->assertForbidden();
        $this->actingAs($nurse)->get('/apps/surgicare/siap-operasi/sebelum-operasi')->assertForbidden();
    }
}
