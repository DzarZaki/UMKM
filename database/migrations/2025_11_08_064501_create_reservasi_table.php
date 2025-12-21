<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservasi', function (Blueprint $table) {
    $table->id();

    $table->foreignId('id_fotografer')
      ->nullable()
      ->constrained('fotografer')
      ->nullOnDelete();

    $table->foreignId('id_kalender')
      ->nullable()
      ->constrained('kalender')
      ->nullOnDelete();


    $table->string('nama');
    $table->string('email');
    $table->string('no_hp');

    $table->string('tipe_paket')->nullable();
    $table->date('tanggal');
    $table->time('waktu_mulai');
    $table->time('waktu_selesai');

    $table->text('keterangan')->nullable();

    $table->enum('status', ['pending','in_progress','done'])
          ->default('pending');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
