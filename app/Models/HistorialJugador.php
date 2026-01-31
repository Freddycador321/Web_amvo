<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialJugador extends Model
{
    use HasFactory;

    protected $table = 'historial_jugadores';

    protected $fillable = [
        'jugador_id',
        'club_id',
        'equipo_id',
        'temporada',
        'estado'
    ];

    // Relación con jugador
    public function jugador()
    {
        return $this->belongsTo(Jugador::class, 'jugador_id');
    }

    // Relación con club
    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id');
    }

    // Relación con equipo
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }
}
