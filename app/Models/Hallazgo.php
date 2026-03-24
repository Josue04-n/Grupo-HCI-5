<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hallazgo extends Model
{
protected $table = 'hallazgos';

    protected $fillable = [
        'prueba_id', 'severidad_id', 'prioridad_id', 'estado_id', 
        'problema', 'evidencia', 'frecuencia', 'recomendacion'
    ];

    public function prueba() { return $this->belongsTo(PruebaUsabilidad::class, 'prueba_id'); }
    public function severidad() { return $this->belongsTo(CatSeveridad::class, 'severidad_id'); }
    public function prioridad() { return $this->belongsTo(CatPrioridad::class, 'prioridad_id'); }
    public function estado() { return $this->belongsTo(CatEstadoHallazgo::class, 'estado_id'); }
}