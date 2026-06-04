<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionBackup extends Model
{
    public $timestamps = false;

    protected $table = 'configuracion_backup';

    protected $fillable = [
        'frecuencia',
        'dia_semana',
        'dia_mes',
        'hora',
    ];
}
