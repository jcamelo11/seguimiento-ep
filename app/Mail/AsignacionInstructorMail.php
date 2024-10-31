<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class AsignacionInstructorMail extends Mailable
{
    use Queueable, SerializesModels;

    public $aprendiz;
    public $instructor;
    public $fechaAsignacion;
    public $esReasignacion;
    public $informes;

    public function __construct($aprendiz, $instructor, $fechaAsignacion, $esReasignacion = false)
    {
        $this->aprendiz = $aprendiz;
        $this->instructor = $instructor;
        $this->fechaAsignacion = $fechaAsignacion;
        $this->esReasignacion = $esReasignacion;

        // Obtener todos los informes de seguimiento del aprendiz y ordenarlos si es necesario
        $this->informes = $aprendiz->informesSeguimiento()->orderBy('fecha_inicio')->get();
    }

    public function build()
    {
        // Formatear la fecha en el asunto
        $fechaAsignacionFormateada = Carbon::parse($this->fechaAsignacion)->translatedFormat('F j \d\e Y');
        
        // Datos adicionales del aprendiz y su programa
        $ficha = $this->aprendiz->programaFormacion->ficha ?? 'sin ficha'; // Acceder a la ficha del programa de formación
        $programa = $this->aprendiz->programaFormacion->nombre_programa ?? 'N/A';
        $ficha = $this->aprendiz->programaFormacion->ficha ?? 'N/A';
        $nivel = $this->aprendiz->programaFormacion->nivel_formacion ?? 'N/A';
        $documento = "{$this->aprendiz->tipo_documento} {$this->aprendiz->numero_documento}";
        $telefono = $this->aprendiz->celular1;
        $correo = $this->aprendiz->correo_personal ?? $this->aprendiz->correo_institucional;
        $modalidad = $this->aprendiz->programaFormacion->modalidad ?? 'N/A';
        $instructorLider = $this->aprendiz->programaFormacion->lider_programa ?? 'N/A';
        $modalidadEtapa = $this->aprendiz->etapaProductiva->modalidad_etapa ?? 'N/A';
        $inicio = $this->aprendiz->etapaProductiva->fecha_inicio ?? 'N/A';
        $final = $this->aprendiz->etapaProductiva->fecha_final ?? 'N/A';
        $empresa = $this->aprendiz->etapaProductiva->empresa ?? 'N/A';
        
        // Determinar el asunto en función de si es asignación o reasignación
        $asunto = $this->esReasignacion
            ? "REASIGNACIÓN DE INSTRUCTOR DE SEGUIMIENTO – $fechaAsignacionFormateada"
            : "ASIGNACIÓN DE INSTRUCTOR DE SEGUIMIENTO – $fechaAsignacionFormateada";

        return $this->subject($asunto)
                    ->view('emails.asignacion_instructor')
                    ->with([
                        'aprendizNombre' => $this->aprendiz->nombres . ' ' . $this->aprendiz->apellidos,
                        'aprendizDocumento' => $documento,
                        'instructorNombre' => $this->instructor->nombres . ' ' . $this->instructor->apellidos,
                        'fechaAsignacion' => $this->fechaAsignacion,
                        'instructorCorreo' => $this->instructor->correo_institucional,
                        'esReasignacion' => $this->esReasignacion,
                        'programa' => $programa,
                        'ficha' => $ficha,
                        'nivel' => $nivel,
                        'documento' => $documento,
                        'telefono' => $telefono,
                        'correo' => $correo,
                        'modalidad' => $modalidad,
                        'instructorLider' => $instructorLider,
                        'modalidadEtapa' => $modalidadEtapa,
                        'final' => $final,
                        'inicio' => $inicio,
                        'instructorLider' => $instructorLider,
                        'modalidadEtapa' => $modalidadEtapa,
                        'inicio' => $inicio,
                        'final' => $final,
                        'empresa' => $empresa,
                        'informes' => $this->informes, 
                    ]);
    }
}
