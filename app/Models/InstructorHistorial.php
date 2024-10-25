<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorHistorial extends Model
{
    use HasFactory;

    protected $table = 'instructor_historials';

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
        return $this->belongsTo(InstructorSeguimiento::class);
    }
    
}
