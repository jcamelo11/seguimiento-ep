<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;


class InformesSeguimiento extends Model
{
    use HasFactory, HasFilamentComments;

    protected $table = 'informes_seguimiento';

    protected $fillable = [
        'aprendiz_id',
        'nombre',
        'fecha_inicio',
        'fecha_entrega',
        'estado_informe',
        'observaciones',
    ];

    public function aprendiz()
    {
        return $this->belongsTo(Aprendiz::class);
    }
}
