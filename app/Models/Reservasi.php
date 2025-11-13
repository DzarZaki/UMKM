<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id_fotografer',
        'id_kalender',
        'nama_klien',
        'email',
        'tanggal',
        'status_reservasi',
    ];

    
    public function fotografer()
    {
        return $this->belongsTo(Fotografer::class);
    }

    public function kalender()
    {
        return $this->belongsTo(Kalender::class);
    }
}
