<?php

namespace App\Exports;

use App\Models\Aprendiz;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;


class AprendizExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;
    /**
     * Obtener todos los aprendices con sus relaciones
     */
    public function collection()
    {
        return Aprendiz::with([
            'programaFormacion',
            'etapaProductiva',
            'instructorSeguimiento',
            'instructorHistorial',
        ])->get();
    }

    /**
     * Definir encabezados
     */
    public function headings(): array
    {
        return [
            
            'NOMBRES',
            'No. DE FICHA',
            'PROGRAMA DE FORMACION',
            'NIVEL DE FORMACION',
            'Tipo TIPO DE DOCUMENTO',
            'NUMERO DE DOCUMENTO',
            'NOMBRES',
            'APELLIDOS',
            'CELULAR 1',
            'CELULAR 2',
            'CORREO ELECTRONICO PERSONAL',
            'CORREO ELECTRONICO MISENA',
            'ESTADO',
            'MODALIDAD FORMACION',
            'MUNICIPIO FICHA',
            'INSTRUCTOR LIDER DE FICHA',
            'GENERO',
            'FECHA FINAL ETAPA LECTIVA',
            'PRESENTO PRUEBAS T&T',
            'FECHA INICIAL CONTRATO APRENDIZAJE - patrocinio ETAPA LECTIVA',
            'ETAPA DE LA PRACTICA    (LECT - PROD)',
            'MODALIDAD DE ETAPA PRODUCTIVA',
            'FECHA INICIO ETAPA PRODUCTIVA',
            'FECHA FINAL ETAPA PRODUCTIVA',
            'FECHA FINAL DE ETAPA PRODUCTIVA ANTES DE LA PRORROGA?',
            'EMPRESA',
            'CIUDAD DE LA PRACTICA',
            'INSTRUCTOR DE SEGUIMIENTO',
            'FECHA DE ASIGNACION DE INSTRUCTOR DE SEGUIMIENTO',

        ];
    }

    /**
     * Mapear datos y relaciones en cada fila
     */
    public function map($aprendiz): array
    {
        return [
            $aprendiz->nombres,
            $aprendiz->programaFormacion ? $aprendiz->programaFormacion->ficha : 'N/A',
            $aprendiz->programaFormacion? $aprendiz->programaFormacion->nombre_programa : 'N/A', 
            $aprendiz->programaFormacion ? $aprendiz->programaFormacion->nivel_formacion : 'N/A',
            $aprendiz->tipo_documento,
            $aprendiz->numero_documento,
            $aprendiz->nombres,
            $aprendiz->apellidos,
            $aprendiz->celular1,
            $aprendiz->celular2,
            $aprendiz->correo_personal,
            $aprendiz->correo_institucional,
            $aprendiz->estado,
            $aprendiz->programaFormacion ? $aprendiz->programaFormacion->modalidad : 'N/A',
            $aprendiz->programaFormacion ? $aprendiz->programaFormacion->municipio_ficha : 'N/A',
            $aprendiz->programaFormacion ? $aprendiz->programaFormacion->lider_programa : 'N/A',
            $aprendiz->genero,
            $aprendiz->programaFormacion ? $aprendiz->programaFormacion->fecha_final : 'N/A',
            $aprendiz->presento_pruebas_tt,
            $aprendiz->etapaProductiva ? $aprendiz->etapaProductiva->patrocinio : 'N/A',
            $aprendiz->etapaProductiva ? $aprendiz->etapaProductiva->etapa_de_la_practica : 'N/A',
            $aprendiz->etapaProductiva ? $aprendiz->etapaProductiva->modalidad_etapa : 'N/A',
            $aprendiz->etapaProductiva ? $aprendiz->etapaProductiva->fecha_inicio : 'N/A',
            $aprendiz->etapaProductiva ? $aprendiz->etapaProductiva->fecha_final : 'N/A',
            $aprendiz->etapaProductiva ? $aprendiz->etapaProductiva->fecha_final_prorroga : 'N/A',
            $aprendiz->etapaProductiva ? $aprendiz->etapaProductiva->empresa : 'N/A',
            $aprendiz->etapaProductiva ? $aprendiz->etapaProductiva->ciudad_practica : 'N/A',
            $aprendiz->instructorSeguimiento 
            ? $aprendiz->instructorSeguimiento->nombre . ' ' . $aprendiz->instructorSeguimiento->apellido 
            : 'N/A',
            $aprendiz->fecha_asignacion,
        ];
    }
}
