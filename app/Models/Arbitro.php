<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arbitro extends Model
{
    use HasFactory;

    protected $table = 'arbitros';

    // Campos asignables masivamente
    protected $fillable = [
        'nombre',
        'apellido',
        'ci',
        'telefono',
        'email',
        'foto',
        'nivel',
        'estado',
        'observaciones'
    ];

    // Valores posibles de nivel (enum estático)
    const NIVELES = ['NIVEL 1','NIVEL 2','NIVEL 3'];

    // Valores posibles de estado
    //const ESTADOS = ['ACTIVO','INACTIVO'];
}
