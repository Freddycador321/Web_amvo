<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'nombre',
        'apellido',
        'ci',
        'email',
        'password',
        'rol',
        'telefono',
        'estado'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Helpers de rol
    public function esAdmin() {
        return $this->rol === 'ADMIN';
    }

    public function esSecretaria() {
        return $this->rol === 'SECRETARIA';
    }
}
