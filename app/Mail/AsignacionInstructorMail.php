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

    public function __construct($aprendiz, $instructor, $fechaAsignacion, $esReasignacion = false)
    {
        $this->aprendiz = $aprendiz;
        $this->instructor = $instructor;
        $this->fechaAsignacion = $fechaAsignacion;
        $this->esReasignacion = $esReasignacion;
    }

    public function build()
    {
        // Formatear la fecha en el asunto
        $fechaAsignacionFormateada = Carbon::parse($this->fechaAsignacion)->translatedFormat('F j \d\e Y');

        // Determinar el asunto en función de si es asignación o reasignación
        $asunto = $this->esReasignacion
            ? "REASIGNACIÓN DE INSTRUCTOR DE SEGUIMIENTO – $fechaAsignacionFormateada"
            : "ASIGNACIÓN DE INSTRUCTOR DE SEGUIMIENTO – $fechaAsignacionFormateada";

        return $this->subject($asunto)
                    ->view('emails.asignacion_instructor') // Referencia a la vista
                    ->with([
                        'aprendizNombre' => $this->aprendiz->nombres . ' ' . $this->aprendiz->apellidos,
                        'aprendizDocumento' => "{$this->aprendiz->tipo_documento} {$this->aprendiz->numero_documento}",
                        'instructorNombre' => $this->instructor->nombres . ' ' . $this->instructor->apellidos,
                        'fechaAsignacion' => $this->fechaAsignacion,
                        'instructorCorreo' => $this->instructor->correo_institucional,
                        'esReasignacion' => $this->esReasignacion,
                    ]);
    }
}
