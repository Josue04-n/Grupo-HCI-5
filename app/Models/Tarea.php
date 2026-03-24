<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
protected $table = 'tareas';

    protected $fillable = [
        'prueba_id', 'codigo', 'escenario', 'resultado_esperado', 
        'metrica_principal', 'criterio_exito', 'guion_texto', 'pregunta_seguimiento'
    ];

    public function prueba() { return $this->belongsTo(PruebaUsabilidad::class, 'prueba_id'); }
}
