<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Jugador extends Model
{
    use HasFactory;

    protected $table = 'jugadores';

    protected $fillable = [
        'nombre','apellido','ci','fecha_naci','rama','nacionalidad',
        'direccion','telefono','email','altura_cm','peso_kg',
        'posicion','estado','contacto_emergencia','telefono_emergencia','foto'
    ];

    // Relación con jugador_equipo_categoria (historial de equipos/categorías)
    public function jugadorEquipoCategorias()
    {
        return $this->hasMany(JugadorEquipoCategoria::class);
    }

    // Scope para jugadores activos
    public function scopeActivo($query)
    {
        return $query->where('estado','ACTIVO');
    }

    // Mutator para calcular edad
    public function getEdadAttribute()
    {
        return Carbon::parse($this->fecha_naci)->age;
    }
}
