<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Arbitro;

class ArbitroFactory extends Factory
{
    protected $model = Arbitro::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'ci' => $this->faker->unique()->numberBetween(1000000, 99999999),
            'telefono' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'foto' => null, // Puedes poner ruta de foto o faker->image()
            'nivel' => $this->faker->randomElement(Arbitro::NIVELES),
            'estado' => $this->faker->randomElement(Arbitro::ESTADOS),
            'observaciones' => $this->faker->optional()->text(100),
        ];
    }
}
