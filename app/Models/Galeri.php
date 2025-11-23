<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'judul',
        'file_galeri',
    ];
}
