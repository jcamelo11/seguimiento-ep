<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;
use Illuminate\Notifications\Notifiable;


class InformesSeguimiento extends Model
{
    use HasFactory, HasFilamentComments, Notifiable;

    protected $table = 'informes_seguimiento';

    protected $fillable = [
        'aprendiz_id',
        'nombre',
        'fecha_inicio',
        'fecha_entrega',
        'estado_informe',
        'observaciones',
        'subido_drive',
    ];

    public function aprendiz()
    {
        return $this->belongsTo(Aprendiz::class);
    }
}
