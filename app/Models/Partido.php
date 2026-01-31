<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    use HasFactory;

    protected $fillable = [
        'torneo_id',
        'equipo_a_id',
        'equipo_b_id',
        'categoria_id',
        'rama_id',
        'fecha',
        'marcador_a',
        'marcador_b'
    ];

    // Relaciones
    public function torneo() { return $this->belongsTo(Torneo::class); }
    public function equipoA() { return $this->belongsTo(Equipo::class,'equipo_a_id'); }
    public function equipoB() { return $this->belongsTo(Equipo::class,'equipo_b_id'); }
    public function categoria() { return $this->belongsTo(Categoria::class); }
    public function rama() { return $this->belongsTo(Rama::class); }
}
