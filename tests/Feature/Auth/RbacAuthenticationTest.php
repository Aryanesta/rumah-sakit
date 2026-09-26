<?php

namespace Tests\Feature\Auth;

use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RbacAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders_with_responsive_layout_and_role_options(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('data-guest-theme="pastel"', false);
        $response->assertSee('Rumah Sakit Sehat');
        $response->assertSee('Selamat datang');
        $response->assertSee('Masuk ke SIMRS');
    }

    public function test_nurse_can_authenticate_using_email_and_role_is_identified(): void
    {
        $nurse = User::factory()->nurse()->create([
            'name' => 'Ns. Siti Rahma',
            'email' => 'nurse@rumahsakit.com',
            'username' => 'nurse_siti',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'nurse@rumahsakit.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($nurse);
        $this->assertTrue(auth()->user()->isNurse());
        $this->assertEquals(UserRole::Nurse, auth()->user()->role);

        $response->assertRedirect(route('dashboard', absolute: false));
        $response->assertSessionHas('login_greeting');
    }

    public function test_nurse_can_authenticate_using_username_and_role_is_identified(): void
    {
        $nurse = User::factory()->nurse()->create([
            'name' => 'Ns. Dewi Lestari',
            'username' => 'nurse_dewi',
            'email' => 'dewi@rumahsakit.com',
            'password' => Hash::make('secret-nurse'),
        ]);

        $response = $this->post('/login', [
            'email' => 'nurse_dewi',
            'password' => 'secret-nurse',
        ]);

        $this->assertAuthenticatedAs($nurse);
        $this->assertTrue(auth()->user()->isNurse());
        $this->assertEquals(UserRole::Nurse, auth()->user()->role);
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_patient_can_authenticate_using_email_and_role_is_identified(): void
    {
        $patient = User::factory()->patient()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi.pasien@gmail.com',
            'username' => 'budisantoso',
            'password' => Hash::make('patientpass'),
        ]);

        $response = $this->post('/login', [
            'email' => 'budi.pasien@gmail.com',
            'password' => 'patientpass',
        ]);

        $this->assertAuthenticatedAs($patient);
        $this->assertTrue(auth()->user()->isPatient());
        $this->assertEquals(UserRole::Patient, auth()->user()->role);
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_patient_can_authenticate_using_username_and_role_is_identified(): void
    {
        $patient = User::factory()->patient()->create([
            'name' => 'Ahmad Yusuf',
            'username' => 'ahmadyusuf',
            'email' => 'ahmad@example.com',
            'password' => Hash::make('pasien123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'ahmadyusuf',
            'password' => 'pasien123',
        ]);

        $this->assertAuthenticatedAs($patient);
        $this->assertTrue(auth()->user()->isPatient());
        $this->assertEquals(UserRole::Patient, auth()->user()->role);
    }

    public function test_role_cannot_be_manipulated_via_login_payload(): void
    {
        $patient = User::factory()->patient()->create([
            'email' => 'regular@patient.com',
            'password' => Hash::make('securepass'),
        ]);

        // Attempt privilege escalation via POST payload injection
        $this->post('/login', [
            'email' => 'regular@patient.com',
            'password' => 'securepass',
            'role' => 'superadmin',
        ]);

        $this->assertAuthenticatedAs($patient);
        $this->assertEquals(UserRole::Patient, auth()->user()->role);
        $this->assertFalse(auth()->user()->isSuperAdmin());
    }

    public function test_nurse_sees_application_launcher_after_login(): void
    {
        $nurse = User::factory()->nurse()->create([
            'name' => 'Ns. Siti Rahma',
        ]);

        $response = $this->actingAs($nurse)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Ns. Siti Rahma');
        $response->assertSee('Surgicare');
        $response->assertSee('Angsmart');
        $response->assertSee('ANSafe');
    }

    public function test_patient_sees_application_launcher_after_login(): void
    {
        $patient = User::factory()->patient()->create([
            'name' => 'Budi Santoso',
        ]);

        $response = $this->actingAs($patient)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
        $response->assertSee('SIAP OPERASI');
        $response->assertDontSee('Angsmart');
        $response->assertDontSee('ANSafe');
    }

    public function test_seeded_nurse_and_patient_accounts_can_login_directly(): void
    {
        $this->seed(DatabaseSeeder::class);

        // Test seeded Nurse login
        $responseNurse = $this->post('/login', [
            'email' => 'nurse',
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->isNurse());
        $responseNurse->assertRedirect(route('dashboard', absolute: false));

        $this->post('/logout');
        $this->assertGuest();

        // Test seeded Patient login
        $responsePatient = $this->post('/login', [
            'email' => 'pasien',
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->isPatient());
        $responsePatient->assertRedirect(route('dashboard', absolute: false));
    }
}
