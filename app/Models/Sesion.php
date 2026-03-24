<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
protected $table = 'sesiones';
    
    protected $fillable = [
        'prueba_id', 'participante_id', 'tarea_id', 'aplicativo_id', 'fecha_sesion', 'moderador'
    ];

    public function prueba() { return $this->belongsTo(PruebaUsabilidad::class, 'prueba_id'); }
    public function participante() { return $this->belongsTo(Participante::class, 'participante_id'); }
    public function tarea() { return $this->belongsTo(Tarea::class, 'tarea_id'); }
    public function aplicativo() { return $this->belongsTo(CatAplicativo::class, 'aplicativo_id'); }
    public function observacion() { return $this->hasOne(Observacion::class, 'sesion_id'); }
}