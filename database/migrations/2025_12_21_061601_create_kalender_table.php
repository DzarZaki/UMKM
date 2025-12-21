<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Schema::create('kalender', function (Blueprint $table) {
        //     $table->id('id_kalender');
        //     $table->unsignedBigInteger('id_admin');
        //     $table->string('nama_klien');
        //     $table->dateTime('waktu_mulai');
        //     $table->dateTime('waktu_selesai');
        //     $table->string('nomor_hp')->nullable();
        //     $table->string('email')->nullable();
        //     $table->timestamps();
        // });
    }

    public function down(): void
    {
        // Schema::dropIfExists('kalender');
    }
};
