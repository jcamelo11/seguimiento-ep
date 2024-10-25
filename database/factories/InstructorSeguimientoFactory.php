<?php

namespace Database\Factories;

use App\Models\InstructorSeguimiento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InstructorSeguimiento>
 */
class InstructorSeguimientoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombres' => $this->faker->firstName,
            'apellidos' => $this->faker->lastName,
            'telefono' => $this->faker->phoneNumber,
            'correo_personal' => $this->faker->unique()->safeEmail,
            'correo_institucional' => $this->faker->unique()->safeEmail,
            'profesion' => $this->faker->jobTitle,
            'area' => $this->faker->word,
            'tipo_contrato' => $this->faker->randomElement(['Contratista', 'Planta']),
        ];
    
    }
}
