<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hallazgos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('prueba_id')
                  ->constrained('pruebas_usabilidad')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            // Catálogos: tinyIncrements → unsignedTinyInteger
            $table->unsignedTinyInteger('severidad_id');
            $table->foreign('severidad_id')
                  ->references('id')->on('cat_severidades')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->unsignedTinyInteger('prioridad_id');
            $table->foreign('prioridad_id')
                  ->references('id')->on('cat_prioridades')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->unsignedTinyInteger('estado_id');
            $table->foreign('estado_id')
                  ->references('id')->on('cat_estados_hallazgo')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->text('problema');
            $table->text('evidencia')->nullable();
            $table->string('frecuencia', 20)->nullable()
                  ->comment('Ej: 5/6 usuarios');
            $table->text('recomendacion');

            $table->timestamps();

            // Índices para filtros frecuentes en el módulo de hallazgos
            $table->index('severidad_id', 'idx_hallazgo_severidad');
            $table->index('estado_id',    'idx_hallazgo_estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hallazgos');
    }
};
