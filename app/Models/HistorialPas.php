<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialPas extends Model
{
    use HasFactory;

    protected $table = 'historial_pases';

    protected $fillable = [
        'jugador_id',
        'club_anterior_id', 'equipo_anterior_id', 'categoria_anterior_id', 'rama_anterior_id',
        'club_id', 'equipo_id', 'categoria_id', 'rama_id',
        'user_id', 'fecha_cambio',
    ];

    protected $casts = ['fecha_cambio' => 'datetime'];

    public function jugador()           { return $this->belongsTo(Jugador::class); }
    public function usuario()           { return $this->belongsTo(User::class, 'user_id'); }
    public function club()              { return $this->belongsTo(Club::class); }
    public function equipo()            { return $this->belongsTo(Equipo::class); }
    public function categoria()         { return $this->belongsTo(Categoria::class); }
    public function rama()              { return $this->belongsTo(Rama::class); }
    public function clubAnterior()      { return $this->belongsTo(Club::class,     'club_anterior_id'); }
    public function equipoAnterior()    { return $this->belongsTo(Equipo::class,   'equipo_anterior_id'); }
    public function categoriaAnterior() { return $this->belongsTo(Categoria::class,'categoria_anterior_id'); }
    public function ramaAnterior()      { return $this->belongsTo(Rama::class,     'rama_anterior_id'); }
}
