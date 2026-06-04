<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $table = 'clubes';
    protected $fillable = [

    'nombre',
    'logo',
    'sigla',
    'direccion',
    'telefono',
    'email',
    'presidente',
    'fecha_fundacion',
    'colores_oficiales',
    'municipio',
    'departamento',
    'estado'
];


    public function equipos(){
        return $this->hasMany(Equipo::class);
    }

    public function jugadores(){
        return $this->hasMany(Jugador::class);
    }
}

