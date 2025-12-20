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

User::updateOrCreate(
    ['username' => 'admin'], // kondisi pencarian
    [
        'password' => Hash::make('password'),
        'role'     => 'admin',
    ]
);

User::updateOrCreate(
    ['username' => 'fahri'],
    [
        'password' => Hash::make('password'),
        'role'     => 'fotografer',
    ]
);

// VIDEOGRAFER
        User::updateOrCreate(
            ['username' => 'aziz'],
            [
                'password' => Hash::make('password'),
                'role'     => 'videografer',
            ]
        );

        // FOTOGRAFER + VIDEOGRAFER
        User::updateOrCreate(
            ['username' => 'dina'],
            [
                'password' => Hash::make('password'),
                'role'     => 'fotografer_videografer',
            ]
        );
    }
}
