<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AprendizParaCertificacion extends Mailable
{
    use Queueable, SerializesModels;

    public $aprendiz;

    public function __construct($aprendiz)
    {
        $this->aprendiz = $aprendiz;
    }

    public function build()
    {
        $nombreCompleto = $this->aprendiz->nombres . ' ' . $this->aprendiz->apellidos;
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
        
        // Obtener el nombre completo del instructor de seguimiento
        $instructorNombre = $this->aprendiz->instructorSeguimiento 
                            ? $this->aprendiz->instructorSeguimiento->nombres . ' ' . $this->aprendiz->instructorSeguimiento->apellidos
                            : 'N/A';

        return $this->subject("Aprendiz $nombreCompleto $ficha - con informes de seguimiento OK para CERTIFICACIÓN")
                    ->view('emails.informes.aprobado')
                    ->with([
                        'nombreCompleto' => $nombreCompleto,
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
                        'instructorNombre' => $instructorNombre,
                    ]);
    }
}
