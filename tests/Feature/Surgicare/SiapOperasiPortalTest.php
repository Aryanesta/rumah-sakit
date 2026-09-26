<?php

namespace Tests\Feature\Surgicare;

use App\Models\User;
use App\Support\Surgicare\SiapOperasi\GuideProgressRepository;
use App\Support\Surgicare\SiapOperasi\SebelumOperasiContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiapOperasiPortalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        GuideProgressRepository::forget('budi-santoso');
    }

    public function test_patient_can_access_siap_operasi_pages(): void
    {
        $patient = User::factory()->create([
            'email' => 'pasien@rumahsakit.com',
            'username' => 'pasien',
        ]);

        $this->actingAs($patient)->get('/apps/surgicare/siap-operasi')->assertOk();
        $this->actingAs($patient)->get('/apps/surgicare/siap-operasi/sebelum-operasi')->assertOk();
        $this->actingAs($patient)->get('/apps/surgicare/siap-operasi/setelah-operasi')->assertOk();
        $this->actingAs($patient)->get('/apps/surgicare/siap-operasi/keluarga')->assertOk();
        $this->actingAs($patient)->get('/apps/surgicare/siap-operasi/siap-check')->assertOk();
    }

    public function test_checklist_post_updates_monitoring_for_nurse(): void
    {
        $patient = User::factory()->create([
            'email' => 'pasien@rumahsakit.com',
            'username' => 'pasien',
        ]);

        $nurse = User::factory()->nurse()->create();

        foreach (SebelumOperasiContent::masterChecklistItemIds() as $itemId) {
            $this->actingAs($patient)
                ->postJson('/apps/surgicare/siap-operasi/checklist', [
                    'track' => 'sebelum',
                    'item_id' => $itemId,
                    'checked' => true,
                ])
                ->assertOk();
        }

        $response = $this->actingAs($nurse)->get('/apps/surgicare/monitoring');
        $response->assertOk();
        $response->assertSee('Sudah', false);
    }
}
