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

            // Foreign key ke tabel fotografer
            $table->foreignId('id_fotografer')
                  ->constrained('fotografer')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            // Foreign key ke tabel kalender
            $table->foreignId('id_kalender')
                  ->constrained('kalender')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            // Data tambahan
            $table->string('nama_klien');
            $table->string('email');
            $table->date('tanggal');
            $table->enum('status_reservasi', ['pending', 'confirmed', 'cancelled'])
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
