<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SprintBacklogHistory extends Model
{
    protected $table = 'sprint_backlog_history';

    protected $fillable = [
        'aplicativo_id',
        'content',
        'json_data',
        'synthesis',
        'version_name'
    ];

    protected $casts = [
        'json_data' => 'array',
    ];

    public function aplicativo()
    {
        return $this->belongsTo(CatAplicativo::class, 'aplicativo_id');
    }
}
