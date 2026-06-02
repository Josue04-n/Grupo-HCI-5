<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SprintBacklogHistory extends Model
{
    protected $table = 'sprint_backlog_history';

    protected $fillable = [
        'aplicativo_id',
        'content',
        'version_name'
    ];

    public function aplicativo()
    {
        return $this->belongsTo(CatAplicativo::class, 'aplicativo_id');
    }
}
