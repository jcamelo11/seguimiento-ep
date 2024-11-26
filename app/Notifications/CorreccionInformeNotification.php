<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CorreccionInformeNotification extends Notification
{
    use Queueable;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "El instructor {$this->data['instructor']} corrigió el informe '{$this->data['informe']}' del aprendiz {$this->data['aprendiz']}.",
        ];
    }
}
