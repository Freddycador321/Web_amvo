<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Torneo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','descripcion','fecha_inicio','fecha_fin','lugar','estado'];

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function scopeActivo($query)
    {
        return $query->where('estado','ACTIVO');
    }
}
