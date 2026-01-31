<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Jugador;
use App\Models\Club;
use App\Models\Equipo;
use App\Models\Categoria;
use App\Models\Rama;

class JugadorFactory extends Factory
{
    protected $model = Jugador::class;

    public function definition(): array
    {
        // Obtener ids aleatorios de otras tablas
        $club = Club::inRandomOrder()->first();
        $categoria = Categoria::inRandomOrder()->first();
        $rama = Rama::inRandomOrder()->first();
        $equipo = Equipo::where('club_id', $club?->id ?? 1)
                        ->where('categoria_id', $categoria?->id ?? 1)
                        ->where('rama_id', $rama?->id ?? 1)
                        ->inRandomOrder()
                        ->first();

        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'fecha_nacimiento' => $this->faker->date('Y-m-d','2015-01-01'),
            'club_id' => $club?->id ?? 1,
            'equipo_id' => $equipo?->id ?? 1,
            'categoria_id' => $categoria?->id ?? 1,
            'rama_id' => $rama?->id ?? 1,
            'posicion' => $this->faker->randomElement(['arquero','defensa','mediocampo','delantero']),
            'foto' => null,
            'estado' => $this->faker->randomElement(['activo','suspendido','retirado'])
        ];
    }
}
