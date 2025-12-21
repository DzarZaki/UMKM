<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kalender extends Model
{
    protected $table = 'kalender';

    protected $fillable = [
    'user_id',
    'nama_klien',
    'nomor_hp',
    'email',
    'tanggal',
    'waktu_mulai',
    'waktu_selesai'
];
    public $timestamps = false;
}
