<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'club_id',
        'categoria_id',
        'rama_id',
        'entrenador_id',
        'estado'
    ];

    // Relaciones
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function rama()
    {
        return $this->belongsTo(Rama::class);
    }

    public function entrenador()
    {
        return $this->belongsTo(Entrenador::class);
    }

    public function jugadores()
    {
        return $this->hasMany(Jugador::class);
    }

    public function torneosEquipos()
    {
        return $this->hasMany(TorneoEquipo::class);
    }

    public function partidosA()
    {
        return $this->hasMany(Partido::class,'equipo_a_id');
    }

    public function partidosB()
    {
        return $this->hasMany(Partido::class,'equipo_b_id');
    }
}
