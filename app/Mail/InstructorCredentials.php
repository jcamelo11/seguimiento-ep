<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class InstructorCredentials extends Mailable
{
    use Queueable, SerializesModels;

    public $user; 
    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $password) 
    { 
        $this->user = $user; 
        $this->password = $password; 
    } 

    public function build() 
    { 
        return $this->subject('Credenciales de Acceso a la Plataforma de Seguimiento') 
        ->view('emails.instructor-credentials'); 
    }



    
}
