<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InformeSubidoNotification extends Notification
{
    use Queueable;

    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['database']; // Canal de notificación
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "El instructor {$this->data['instructor']} notificó que subió al Drive {$this->data['updatedCount']} informe(s) del aprendiz {$this->data['aprendiz']}.",
        ];
    }
}

