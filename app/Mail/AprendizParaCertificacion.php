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

        return $this->subject("Aprendiz $nombreCompleto $ficha - con informes de seguimiento OK para CERTIFICACIÓN")
                    ->view('emails.informes.aprobado')
                    ->with([
                        'nombreCompleto' => $nombreCompleto,
                    ]);
    }
}
