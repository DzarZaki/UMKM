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
        'nama_klien',
        'email',
        'tanggal',
        'status_reservasi',
    ];

    public function fotografer()
    {
        return $this->belongsTo(Fotografer::class, 'id_fotografer');
    }

    public function kalender()
    {
        return $this->belongsTo(Kalender::class, 'id_kalender');
    }
}
