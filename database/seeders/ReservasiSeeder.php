<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservasi;
use Illuminate\Support\Str;

class ReservasiSeeder extends Seeder
{
    public function run(): void
    {
        // Kalau mau reset data reservasi tiap seed (LOCAL only), uncomment:
        // Reservasi::truncate();

        $baseDate = now();

        $make = function (int $i, string $status) use ($baseDate) {
            $tanggal = $baseDate->copy()->addDays($i % 5`)->toDateString();

            $startHour = 8 + ($i % 6); // 08..13
            $waktuMulai = sprintf('%02d:00:00', $startHour);
            $waktuSelesai = sprintf('%02d:00:00', $startHour + 1);

            $paket = ['Basic','Premium','Wedding','Prewedding'][($i - 1) % 4];

            return [
                'id_fotografer' => null, // aman walau fotografer belum di-assign
                'id_kalender'   => null,

                'nama'  => "Klien {$status} {$i}",
                'email' => "klien_{$status}_{$i}@example.com",
                'no_hp' => '08' . str_pad((string)(100000000 + $i), 9, '0', STR_PAD_LEFT),

                'tipe_paket' => $paket,
                'tanggal' => $tanggal,
                'waktu_mulai' => $waktuMulai,
                'waktu_selesai' => $waktuSelesai,

                'keterangan' => "Seeder dummy ({$status})",
                'status' => $status,
            ];
        };

        $rows = [];

        // 3 new
        for ($i = 1; $i <= 3; $i++) $rows[] = $make($i, 'new');

        // 2 pending
        for ($i = 4; $i <= 5; $i++) $rows[] = $make($i, 'pending');

        // 4 in_progress
        for ($i = 6; $i <= 9; $i++) $rows[] = $make($i, 'in_progress');

        // 1 done
        $rows[] = $make(10, 'done');

        foreach ($rows as $data) {
            Reservasi::create($data);
        }
    }
}
