<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Fotografer;

class FotograferSeeder extends Seeder
{
    public function run(): void
    {
        // ambil user yang role-nya fotografer atau fotografer_videografer
        $users = User::whereIn('role', ['fotografer', 'fotografer_videografer', 'videografer'])->get();

        // spesialisasi optional (ubah sesuai kebutuhan)
        $specMap = [
            'lathuf'  => 'Wedding',
            'fahmi'   => 'Prewedding',
            'djo'     => 'Wisuda',
            'redya'   => 'Lamaran',
            'david'   => 'Wedding',
            'gilang'  => 'Prewedding',
            'irgi'    => 'Wisuda',
            'noval'   => 'Lamaran',
            'habib'   => 'Wedding',
            'ilham'   => 'Prewedding',
            'riziq'   => 'Wisuda',
            'afrizal' => 'Lamaran',
            'syahid'  => 'Wedding',
            'wahyu'   => 'Prewedding',
            'rama'    => 'Wisuda',
        ];

        foreach ($users as $u) {
            Fotografer::updateOrCreate(
                ['user_id' => $u->id], // 1 user = 1 row fotografer
                [
                    'nama_fotografer' => $u->username,
                    'spesialisasi' => $specMap[$u->username] ?? null,
                ]
            );
        }
    }
}
