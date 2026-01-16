<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','club_id','categoria_id','entrenador_id','estado'];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function entrenador()
    {
        return $this->belongsTo(User::class,'entrenador_id');
    }

    public function jugadorEquipoCategorias()
    {
        return $this->hasMany(JugadorEquipoCategoria::class);
    }

    public function scopeActivo($query)
    {
        return $query->where('estado','ACTIVO');
    }
}
