<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('cat_severidades')->upsert([
            ['id' => 1, 'nombre' => 'Baja'],
            ['id' => 2, 'nombre' => 'Media'],
            ['id' => 3, 'nombre' => 'Alta'],
            ['id' => 4, 'nombre' => 'Crítica'],
        ], ['id'], ['nombre']);
    }

    public function down(): void
    {
        // No destructivo en down
    }
};
