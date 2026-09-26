<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_renders_hero_section_and_three_main_apps(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('RS Sehat Sejahtera');
        $response->assertSee('Presisi, Keselamatan, &amp; Intelijen', false);
        $response->assertSee('Satu Ekosistem Medis', false);

        // Three Main Apps and Factual Descriptions
        $response->assertSee('Surgicon');
        $response->assertSee('Pencatatan alur operasi bedah');
        $response->assertSee('Angsmart');
        $response->assertSee('Dokumentasi asuhan keperawatan');
        $response->assertSee('ANSafe');
        $response->assertSee('Pengkajian risiko jatuh pasien');

        // Login CTA buttons
        $response->assertSee('Masuk ke Aplikasi');

        // Footer
        $response->assertSee('Hak Cipta Dilindungi Undang-Undang');
    }

    public function test_authenticated_user_sees_dashboard_link_on_landing_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('Buka Dashboard');
    }
}
