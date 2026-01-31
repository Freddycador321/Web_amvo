<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabla extends Model
{
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
        return $this->belongsTo(Equipo::class);
    }

    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }

    public function rama() {
        return $this->belongsTo(Rama::class);
    }
}
