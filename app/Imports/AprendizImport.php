<?php

namespace App\Imports;

use App\Models\Aprendiz;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AprendizImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Aprendiz([
            'tipo_documento' => $row['tipo_documento'],
            'numero_documento' => $row['numero_documento'],
            'nombres' => $row['nombres'],
            'apellidos' => $row['apellidos'],
            'celular1' => $row['celular_1'],
            'celular2' => $row['celular_2'],
            'correo_personal' => $row['correo_personal'],
            'correo_institucional' => $row['correo_institucional'],
            'estado' => $row['estado'],
        ]);
    }

    /**
     * Validar los datos de cada fila (opcional)
     */
    public function rules(): array
    {
        return [
            'nombres' => 'required',
            'apellidos' => 'required',
            'tipo_documento' => 'required',
            'numero_documento' => 'required|unique:aprendices,numero_documento', // Asegura que no se repitan
            // Agrega más reglas según sea necesario
        ];
    }
}
