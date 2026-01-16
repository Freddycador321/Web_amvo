<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelArbitro extends Model
{
    use HasFactory;

    protected $table = 'niveles_arbitro';

    protected $fillable = ['nombre','descripcion'];

    public function arbitros()
    {
        return $this->hasMany(Arbitro::class,'nivel_id');
    }
}
