<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arbitro extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','apellido','ci','telefono','email','nivel_id','estado','foto'];

    public function nivel()
    {
        return $this->belongsTo(NivelArbitro::class,'nivel_id');
    }

    public function scopeActivo($query)
    {
        return $query->where('estado','ACTIVO');
    }
}
