<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Superadmin user
        User::updateOrCreate(
            ['email' => 'superadmin@rumahsakit.com'],
            [
                'name' => 'Super Administrator',
                'username' => 'superadmin',
                'role' => UserRole::Superadmin,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Standard user
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'username' => 'testuser',
                'role' => UserRole::Patient,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
