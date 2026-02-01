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
    //Para traer 
    public function scopeIndex($query){
        return $query->join('clubes', 'jugadores.club_id','clubes.id')
        ->join('equipos','jugadores.equipo_id','equipos.id')
        ->join('categorias','jugadores.categoria_id','categorias.id')
        ->join('ramas','jugadores.rama_id','ramas.id')
        ->select('jugadores.*','clubes.nombre as nombre_club','equipos.nombre as nombre_equipo','categorias.nombre as nombre_categoria','ramas.nombre as nombre_rama')
        ->get(); 
    }
}
