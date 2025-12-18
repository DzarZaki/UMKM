<?php

namespace App\Models;

// Perbaikan Error HasFactory (Nomor 2)
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    // Perbaikan Error "Table galeris doesn't exist"
    protected $table = 'galeri'; 

    protected $fillable = [
        'judul',
        'file_galeri',
    ];
}