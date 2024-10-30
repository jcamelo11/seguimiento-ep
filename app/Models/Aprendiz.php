<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Mail\AsignacionInstructorMail;
use Illuminate\Support\Facades\Mail;

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

    public function instructorHistorial()
    {
        return $this->hasMany(InstructorHistorial::class);
    }

    public function informesSeguimiento(): HasMany
    {
        return $this->hasMany(InformesSeguimiento::class);
    }

    public function avales(): HasMany
    {
        return $this->hasMany(Aval::class);
    }

    protected static function boot()
    {
        parent::boot();
    
        static::updating(function ($aprendiz) {
            // Solo guardar el historial si instructor_seguimiento_id cambia
            if ($aprendiz->isDirty('instructor_seguimiento_id')) {
                InstructorHistorial::create([
                    'aprendiz_id' => $aprendiz->id,
                    'instructor_seguimiento_id' => $aprendiz->getOriginal('instructor_seguimiento_id'),
                    'fecha_asignacion' => $aprendiz->getOriginal('fecha_asignacion'),
                ]);
            }
            
            $esReasignacion = !is_null($aprendiz->getOriginal('instructor_seguimiento_id'));

            // Solo enviar correo si cambia el instructor o la fecha de asignación
            if ($aprendiz->isDirty('instructor_seguimiento_id') || $aprendiz->isDirty('fecha_asignacion')) {
                // Obtener el nuevo instructor y la fecha de asignación
                $instructor = $aprendiz->instructorSeguimiento;
                $fechaAsignacion = $aprendiz->fecha_asignacion;

                // Enviar correo al aprendiz sobre la asignación o reasignación
                Mail::to($aprendiz->correo_institucional ?? $aprendiz->correo_personal)
                    ->send(new AsignacionInstructorMail($aprendiz, $instructor, $fechaAsignacion, $esReasignacion));
            }
        });
    }

   



    

  
    
}
