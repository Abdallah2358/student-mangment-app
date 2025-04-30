<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Teacher;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create(
            [
                'name' => 'Admin',
                'email' => 'Admin@example.com',
                'role' => RolesEnum::ADMIN,
                'password' => bcrypt('password'), // password
                'phone' => '1234567890',
                'address' => '123 Main St',
            ]
        );
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => RolesEnum::TEACHER,
            'password' => bcrypt('password'), // password
            'phone' => '1234567890',
            'address' => '123 Main St',

        ]);
        Teacher::create(
            [
                'user_id' => 1,
            ]
        );
    }
}
