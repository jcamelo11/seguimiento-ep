<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramaFormacion extends Model
{
    use HasFactory;

    protected $table = 'programa_formacion';

    protected $fillable = [
        'nombre_programa',
        'ficha',
        'nivel_formacion',
        'modalidad',
        'estado_formacion',
        'municipio_ficha',
        'lider_programa',
        'fecha_final',
        
    ];

    public function aprendices()
    {
        return $this->hasMany(Aprendiz::class);
    }

    public function getNombreConFichaAttribute()
    {
        return " {$this->ficha} - {$this->nombre_programa}  ";
    }
}
