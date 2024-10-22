<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aval extends Model
{
    use HasFactory;

    protected $table = 'avales';

    protected $fillable = [
        'aprendiz_id',
        'fecha',
        'observaciones',
    ];

    public function aprendiz()
    {
        return $this->belongsTo(Aprendiz::class);
    }
}
