<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /* =========================
     |  ROLE HELPERS
     ========================= */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isFotografer(): bool
    {
        return in_array($this->role, [
            'fotografer',
            'videografer',
            'fotografer_videografer'
        ]);
    }

    /* =========================
     |  RELATIONS
     ========================= */

    // 🔑 USER → RESERVASI
    public function reservasi()
    {
        return $this->hasMany(Reservasi::class);
    }
}
