<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    protected $table = 'participantes';

    protected $fillable = [
        'prueba_id', 'codigo', 'perfil', 'experiencia', 'edad'
    ];

    public function prueba() { return $this->belongsTo(PruebaUsabilidad::class, 'prueba_id'); }
}
