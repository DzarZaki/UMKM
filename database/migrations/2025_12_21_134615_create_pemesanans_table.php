<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('email');
            $table->string('nomor_hp');

            // BOLEH NULL
            $table->string('tipe_paket')->nullable();

            $table->date('tanggal');
            $table->time('waktu');

            // BOLEH NULL
            $table->text('keterangan')->nullable();

            $table->enum('status', [
                'pending',
                'in_progress',
                'done'
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
