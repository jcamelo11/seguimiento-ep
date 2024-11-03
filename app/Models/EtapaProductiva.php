<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EtapaProductiva extends Model
{
    use HasFactory;

    protected $table = 'etapa_productiva';

    protected $fillable = [
        'modalidad_etapa',
        'fecha_inicio',
        'fecha_final',
        'fecha_final_prorroga',
        'empresa',
        'ciudad_practica',
        'etapa_de_la_practica',
        'patrocinio',
        'aprendiz_id',
    ];

    public function aprendiz(): BelongsTo
    {
        return $this->belongsTo(Aprendiz::class, 'aprendiz_id'); // Especificar la clave foránea
    }
}
