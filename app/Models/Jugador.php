<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    
    use HasFactory;
    protected $table = 'jugadores';
    protected $fillable = [
        'nombre',
        'apellido',
        'ci',
        'club_id',
        'equipo_id',
        'categoria_id',
        'rama_id',
        'fecha_nacimiento',
        'posicion',
        'foto',
        'estado'
    ];

    // Relaciones
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function rama()
    {
        return $this->belongsTo(Rama::class);
    }

    public function historial()
    {
        return $this->hasMany(HistorialJugador::class);
    }

    public function jugadorEquipoCategorias()
    {
        return $this->hasMany(JugadorEquipoCategoria::class);
    }
}
