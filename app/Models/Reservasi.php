<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasi';

    protected $fillable = [
        'id_fotografer',
        'id_kalender',
        'nama',
        'email',
        'no_hp',
        'tipe_paket',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'keterangan',
        'status',
    ];
    public function fotografer()
{
    return $this->belongsTo(Fotografer::class, 'id_fotografer');
}

}
