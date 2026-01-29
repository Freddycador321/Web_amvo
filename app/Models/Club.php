<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;
    protected $table = 'clubes';

    protected $fillable = ['nombre','ciudad','direccion','telefono','email','estado','foto'];

    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    public function scopeActivo($query)
    {
        return $query->where('estado','ACTIVO');
    }
}
