<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaUsabilidad extends Model
{
    protected $table = 'pruebas_usabilidad';

    protected $fillable = [
        'user_id', 'metodo_id', 'estado_id', 'nombre', 'producto', 
        'modulo', 'objetivo', 'perfil_usuarios', 'fecha', 'lugar', 'duracion'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function metodo() { return $this->belongsTo(CatMetodo::class, 'metodo_id'); }
    public function estado() { return $this->belongsTo(CatEstadoPrueba::class, 'estado_id'); }
    public function participantes() { return $this->hasMany(Participante::class, 'prueba_id'); }
    public function tareas() { return $this->hasMany(Tarea::class, 'prueba_id'); }
    public function hallazgos() { return $this->hasMany(Hallazgo::class, 'prueba_id'); }

}