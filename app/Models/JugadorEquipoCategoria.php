<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JugadorEquipoCategoria extends Model
{
    use HasFactory;

    protected $table = 'jugador_equipo_categoria';

    protected $fillable = ['jugador_id','equipo_id','categoria_id','fecha_inicio','fecha_fin'];

    public function jugador()
    {
        return $this->belongsTo(Jugador::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function scopeActuales($query)
    {
        return $query->whereNull('fecha_fin');
    }
}
