<?php

namespace Database\Factories;

use App\Models\Aprendiz;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AprendizFactory extends Factory
{
    protected $model = Aprendiz::class;

    public function definition()
    {
        return [
            'tipo_documento' => $this->faker->randomElement(['CC', 'TI', 'CE']),
            'numero_documento' => $this->faker->unique()->numerify('##########'),
            'nombres' => $this->faker->firstName,
            'apellidos' => $this->faker->lastName,
            'celular1' => $this->faker->phoneNumber,
            'celular2' => $this->faker->optional()->phoneNumber,  // Puede ser null
            'correo_personal' => $this->faker->unique()->safeEmail,
            'correo_institucional' => $this->faker->optional()->safeEmail,  // Puede ser null
            'genero' => $this->faker->randomElement(['Masculino', 'Femenino', 'Otro']),
            'estado' => $this->faker->randomElement(['Activo', 'Por Certificar', 'Certificado', 'Cancelado/Retirado']),
            'pruebas_tyt' => $this->faker->boolean,
            'programa_formacion_id' => \App\Models\ProgramaFormacion::factory(),
        ];
    }
}
