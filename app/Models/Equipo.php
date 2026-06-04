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

    public function jugadores()
    {
        return $this->hasMany(Jugador::class);
    }

    public function scopeIndex($query){
    return $query
        ->leftJoin('clubes', 'equipos.club_id', 'clubes.id')
        ->leftJoin('categorias', 'equipos.categoria_id', 'categorias.id')
        ->leftJoin('ramas', 'equipos.rama_id', 'ramas.id')
        ->select(
            'equipos.*',
            'clubes.nombre as nombre_club',
            'categorias.nombre as nombre_categoria',
            'ramas.nombre as nombre_rama'
        )
        ->get();
}

}
