<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','descripcion','edad_min','edad_max'];

    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    public function jugadorEquipoCategorias()
    {
        return $this->hasMany(JugadorEquipoCategoria::class);
    }

    public function scopeActivo($query)
    {
        return $query->whereHas('jugadorEquipoCategorias', function($q){
            $q->where('fecha_fin', null);
        });
    }
}
