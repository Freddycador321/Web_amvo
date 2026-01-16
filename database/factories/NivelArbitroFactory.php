<?php

namespace Database\Factories;

use App\Models\NivelArbitro;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NivelArbitro>
 */
class NivelArbitroFactory extends Factory
{
    protected $model = NivelArbitro::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->randomElement([
                'PRIMERA',
                'SEGUNDA',
                'TERCERA',
                'NACIONAL',
                'INTERNACIONAL'
            ]),
            'descripcion' => $this->faker->sentence(6),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
