<?php

namespace Database\Factories;

use App\Models\Arbitro;
use App\Models\NivelArbitro;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArbitroFactory extends Factory
{
    protected $model = Arbitro::class;

    public function definition(): array
    {
        return [
            'nombre'   => $this->faker->firstName(),
            'apellido' => $this->faker->lastName(),
            'ci'       => $this->faker->unique()->numerify('########'),
            'telefono' => $this->faker->optional()->phoneNumber(),
            'email'    => $this->faker->optional()->safeEmail(),
            'nivel_id' => NivelArbitro::inRandomOrder()->first()->id,
            'estado'   => $this->faker->randomElement(['ACTIVO', 'INACTIVO']),
            'foto'     => 'arbitros/default.png',
        ];
    }
}
