<?php

namespace Tests\Feature\Auth;

use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SuperadminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_renders_hospital_branding_and_quick_fill_for_superadmin(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Rumah Sakit Sehat');
        $response->assertSee('Akun Demo Superadmin');
        $response->assertSee('superadmin');
    }

    public function test_superadmin_can_authenticate_using_username(): void
    {
        $superadmin = User::factory()->create([
            'name' => 'Super Administrator',
            'username' => 'superadmin',
            'email' => 'superadmin@rumahsakit.com',
            'role' => UserRole::Superadmin,
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'superadmin',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($superadmin);
        $response->assertRedirect(route('dashboard', absolute: false));
        $response->assertSessionHas('login_greeting');
    }

    public function test_superadmin_can_authenticate_using_email(): void
    {
        $superadmin = User::factory()->create([
            'name' => 'Super Administrator',
            'username' => 'superadmin',
            'email' => 'superadmin@rumahsakit.com',
            'role' => UserRole::Superadmin,
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'superadmin@rumahsakit.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($superadmin);
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_dashboard_greets_superadmin_with_name_and_role(): void
    {
        $superadmin = User::factory()->create([
            'name' => 'Super Administrator',
            'username' => 'superadmin',
            'role' => UserRole::Superadmin,
        ]);

        $response = $this->actingAs($superadmin)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Selamat Datang,');
        $response->assertSee('Super Administrator');
        $response->assertSee('Superadmin');
        $response->assertSee('Modul Akses Cepat Superadmin');
    }

    public function test_seeded_superadmin_can_login_directly(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->post('/login', [
            'email' => 'superadmin',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->isSuperAdmin());
    }

    public function test_authentication_fails_with_wrong_password_for_superadmin(): void
    {
        User::factory()->create([
            'username' => 'superadmin',
            'role' => UserRole::Superadmin,
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'superadmin',
            'password' => 'incorrect-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }
}
