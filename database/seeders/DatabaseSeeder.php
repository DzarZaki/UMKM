<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'username' => 'Dzar',
        //     'password' => 'password',
        //     'role' 
        // ]);
        User::create([
            'username' => 'admin',
            'password' => Hash::make('password'), 
            'role'     => 'admin',
        ]);
        User::create([
            'username' => 'fg',
            'password' => Hash::make('password'), 
            'role'     => 'fg',
        ]);
    }
}
