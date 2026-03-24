<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
protected $table = 'observaciones';

    protected $fillable = [
        'sesion_id', 'severidad_id', 'exito', 'eficacia', 'eficiencia', 
        'satisfaccion', 'tiempo_seg', 'errores', 'comentarios', 'problema_detectado', 'mejora_propuesta'
    ];

    public function sesion() { return $this->belongsTo(Sesion::class, 'sesion_id'); }
    public function severidad() { return $this->belongsTo(CatSeveridad::class, 'severidad_id'); }
}