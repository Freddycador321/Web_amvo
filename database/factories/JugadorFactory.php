<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jugador>
 */
class JugadorFactory extends Factory
{
    protected $model = \App\Models\Jugador::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'ci' => $this->faker->unique()->numberBetween(1000000, 99999999),
            'fecha_naci' => $this->faker->date('Y-m-d', '2005-01-01'),
            'rama' => $this->faker->randomElement(['MASCULINO','FEMENINO']),
            'nacionalidad' => 'Boliviano',
            'direccion' => $this->faker->address,
            'telefono' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'altura_cm' => $this->faker->numberBetween(150, 200),
            'peso_kg' => $this->faker->numberBetween(50, 100),
            'posicion' => $this->faker->randomElement(['portero','defensa','centro','punta-nexo']),
            'estado' => 'ACTIVO',
            'contacto_emergencia' => $this->faker->phoneNumber,
            'telefono_emergencia' => $this->faker->phoneNumber,
            'foto' => 'default.jpg'
        ];
    }
}
