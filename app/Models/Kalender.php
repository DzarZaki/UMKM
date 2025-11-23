<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kalender extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'nama_klien',
        'nomor _hp',
        'email',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }

}
