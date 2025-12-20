<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fotografer extends Model
{
    use HasFactory;

    protected $table = 'fotografer';

    protected $fillable = [
        'nama_fotografer',
        'spesialisasi',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'id_fotografer');
    }
}
