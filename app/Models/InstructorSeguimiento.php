<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstructorSeguimiento extends Model
{
    use HasFactory;

    protected $table = 'instructores_seguimiento';

    protected $fillable = [
        'nombres',
        'apellidos',
        'telefono',
        'correo_personal',
        'correo_institucional',
        'profesion',
        'area',
        'tipo_contrato',
    ];

    public function aprendiz()
    {
        return $this->hasMany(Aprendiz::class, 'instructor_seguimiento_id');
    }
}
