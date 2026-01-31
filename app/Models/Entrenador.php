<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrenador extends Model
{
    use HasFactory;
    protected $table = 'entrenadores';

    protected $fillable = [
        'nombre',
        'foto',
        'telefono',
        'estado'
    ];

    // Relación: un entrenador puede tener muchos equipos
    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }
}
