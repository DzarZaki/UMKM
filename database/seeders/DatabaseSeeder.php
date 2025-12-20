<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------
        | ADMIN
        |--------------------------------------------------
        */
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        /*
        |--------------------------------------------------
        | FOTOGRAFER
        |--------------------------------------------------
        */
        $fotografer = [
            'lathuf',
            'fahmi',
            'djo',
            'redya',
            'david',
            'gilang',
            'irgi',
            'noval',
            'habib',
            'ilham',
            'riziq',
            'afrizal',
        ];

        foreach ($fotografer as $nama) {
            User::updateOrCreate(
                ['username' => $nama],
                [
                    'password' => Hash::make('password'),
                    'role'     => 'fotografer',
                ]
            );
        }

        /*
        |--------------------------------------------------
        | VIDEOGRAFER
        |--------------------------------------------------
        */
        $videografer = [
            'hasbi',
            'zainal',
            'diki',
            'ray',
            'enan',
            'royan',
            'dasep',
        ];

        foreach ($videografer as $nama) {
            User::updateOrCreate(
                ['username' => $nama],
                [
                    'password' => Hash::make('password'),
                    'role'     => 'videografer',
                ]
            );
        }

        /*
        |--------------------------------------------------
        | FOTOGRAFER + VIDEOGRAFER
        |--------------------------------------------------
        */
        $doubleRole = [
            'syahid',
            'wahyu',
            'rama',
        ];

        foreach ($doubleRole as $nama) {
            User::updateOrCreate(
                ['username' => $nama],
                [
                    'password' => Hash::make('password'),
                    'role'     => 'fotografer_videografer',
                ]
            );
        }
    }
}
