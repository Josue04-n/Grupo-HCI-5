<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatEstadoHallazgo extends Model
{
    protected $table = 'cat_estados_hallazgo';
    protected $fillable = ['nombre'];
}
