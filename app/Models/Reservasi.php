<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasi';

    protected $fillable = [
        'user_id',
        // 'id_kalender',
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
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
