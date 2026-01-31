<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TorneoEquipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'torneo_id',
        'equipo_id',
        'categoria_id',
        'rama_id',
        'puntos',
        'partidos_jugados',
        'ganados',
        'perdidos',
        'sets_favor',
        'sets_contra'
    ];

    public function equipo() {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }

    public function torneo() {
        return $this->belongsTo(Torneo::class, 'torneo_id');
    }

    public function categoria() {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function rama() {
        return $this->belongsTo(Rama::class, 'rama_id');
    }
}
