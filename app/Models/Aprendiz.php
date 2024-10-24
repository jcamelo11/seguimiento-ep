<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Aprendiz extends Model
{
    use HasFactory;

    protected $table = 'aprendices'; // Nombre de la tabla de las migraciones

    protected $fillable = [
        'tipo_documento',
        'numero_documento',
        'nombres',
        'apellidos',
        'celular1',
        'celular2',
        'correo_personal',
        'correo_institucional',
        'genero',
        'estado',
        'pruebas_tyt',
        'programa_formacion_id',
        'etapa_productiva_id',
        'instructor_seguimiento_id',
        'fecha_asignacion',
    ];

    public function programaFormacion(): BelongsTo
    {
        return $this->belongsTo(ProgramaFormacion::class, 'programa_formacion_id');
    }

    public function etapaProductiva(): HasOne
    {
        return $this->hasOne(EtapaProductiva::class, 'aprendiz_id'); // Especificar la clave foránea
    }

    public function instructorSeguimiento(): BelongsTo
    {
        return $this->belongsTo(InstructorSeguimiento::class, 'instructor_seguimiento_id');
    }

    public function informesSeguimiento(): HasMany
    {
        return $this->hasMany(InformesSeguimiento::class);
    }

    public function avales(): HasMany
    {
        return $this->hasMany(Aval::class);
    }

  
    
}
