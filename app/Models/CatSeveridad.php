<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatSeveridad extends Model
{
    protected $table = 'cat_severidades';
    protected $fillable = ['nombre'];
}
