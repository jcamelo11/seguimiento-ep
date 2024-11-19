<?php

namespace App\Imports;

use App\Models\Aprendiz;
use App\Models\EtapaProductiva;
use App\Models\ProgramaFormacion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Carbon\Carbon;

class AprendizImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;

    private $skippedCount = 0;
    private $importedCount = 0;

    public function model(array $row)
    {
        // Check if the aprendiz already exists
        $existingAprendiz = Aprendiz::where('numero_documento', $row['numero_documento'])->first();

        if ($existingAprendiz) {
            $this->skippedCount++;
            return null; // Skip this record
        }

        $programaFormacion = ProgramaFormacion::firstOrCreate(
            ['ficha' => $row['ficha'] ?? null],
            [
                'nombre_programa' => $row['nombre_programa'] ?? null,
                'nivel_formacion' => $row['nivel_formacion'] ?? null,
                'modalidad' => $row['modalidad'] ?? null,
                'estado_formacion' => $row['estado_formacion'] ?? null,
                'municipio_ficha' => $row['municipio_ficha'] ?? null,
                'lider_programa' => $row['lider_programa'] ?? null,
                'fecha_final' => $this->convertExcelDate($row['fecha_final'] ?? null),
            ]
        );

        $aprendiz = Aprendiz::create([
            'tipo_documento' => $row['tipo_documento'] ?? null,
            'numero_documento' => $row['numero_documento'] ?? null,
            'nombres' => $row['nombres'] ?? null,
            'apellidos' => $row['apellidos'] ?? null,
            'celular1' => $row['celular_1'] ?? null,
            'celular2' => $row['celular_2'] ?? null,
            'correo_personal' => $row['correo_personal'] ?? null,
            'correo_institucional' => $row['correo_institucional'] ?? null,
            'estado' => $row['estado'] ?? null,
            'genero' => $row['genero'] ?? null,
            'programa_formacion_id' => $programaFormacion->id,
        ]);

        $etapaProductiva = new EtapaProductiva([
            'modalidad_etapa' => $row['modalidad_etapa'] ?? null,
            'fecha_inicio' => $this->convertExcelDate($row['fecha_inicio'] ?? null),
            'fecha_final' => $this->convertExcelDate($row['fecha_final'] ?? null),
            'fecha_final_prorroga' => $this->convertExcelDate($row['fecha_final_prorroga'] ?? null),
            'empresa' => $row['empresa'] ?? null,
            'ciudad_practica' => $row['ciudad_practica'] ?? null,
            'etapa_de_la_practica' => $row['etapa_de_la_practica'] ?? null,
            'patrocinio' => $this->convertExcelDate($row['patrocinio'] ?? null),
        ]);

        $aprendiz->etapaProductiva()->save($etapaProductiva);

        $this->importedCount++;

        return $aprendiz;
    }

    private function convertExcelDate($excelDate)
    {
        if (!$excelDate) {
            return null;
        }
        
        if (is_numeric($excelDate)) {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelDate))->format('Y-m-d');
        }

        return $excelDate;
    }

    public function rules(): array
    {
        return [
            'nombres' => 'required',
            'apellidos' => 'required',
            'modalidad_etapa' => 'required',
            'numero_documento' => 'required',
        ];
    }

    public function getSkippedCount()
    {
        return $this->skippedCount;
    }

    public function getImportedCount()
    {
        return $this->importedCount;
    }
}