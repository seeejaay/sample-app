<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Role::factory()->create([
            'name' => 'User',
            'description' => 'User Role with limited permissions',
        ]);

        Position::factory()->create([
            'name' => 'Developer',
            'description' => 'Responsible for developing software applications',
        ]);

        User::factory()->create([
            'firstname' => 'John',
            'middlename' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'email@example.com',
        ]);

    }
}
