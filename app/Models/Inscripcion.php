<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    protected $fillable = ['jugador_equipo_categoria_id','torneo_id','estado'];

    public function jugadorEquipoCategoria()
    {
        return $this->belongsTo(JugadorEquipoCategoria::class);
    }

    public function torneo()
    {
        return $this->belongsTo(Torneo::class);
    }

    public function scopeActivas($query)
    {
        return $query->where('estado','CONFIRMADA');
    }
}
