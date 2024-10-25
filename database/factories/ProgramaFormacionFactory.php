<?php

namespace Database\Factories;

use App\Models\ProgramaFormacion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProgramaFormacion>
 */
class ProgramaFormacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre_programa' => $this->faker->word,
            'ficha' => $this->faker->unique()->numberBetween(1000, 9999),
            'nivel_formacion' => $this->faker->randomElement(['Tecnico', 'Tecnologo', 'Auxiliar', 'Operativo']),
            'modalidad' => $this->faker->randomElement(['Presencial', 'Virtual']),
            'municipio_ficha' => $this->faker->city,
            'lider_programa' => $this->faker->name,
            'fecha_final' => $this->faker->date,
        ];
    
    }
}
