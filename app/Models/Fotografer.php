<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fotografer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nama_fotografer',
        'spesialiisasi',
        'user_id',
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
