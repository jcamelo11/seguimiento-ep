<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seguimiento extends Model
{
    use HasFactory;

    protected $table = 'seguimiento';

    protected $fillable = [
        'aprendiz_id',
        'instructor_seguimiento_id',
        'fecha_asignacion',
    ];

    public function aprendiz()
    {
        return $this->belongsTo(Aprendiz::class);
    }

    public function instructorSeguimiento()
    {
        return $this->belongsTo(InstructorSeguimiento::class, 'instructor_seguimiento_id');
    }

    public function informesSeguimientos()
    {
        return $this->hasMany(InformesSeguimiento::class);
    }

    public function avales()
    {
        return $this->hasMany(Aval::class);
    }
}
