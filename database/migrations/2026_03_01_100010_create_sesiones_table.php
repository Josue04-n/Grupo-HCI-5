<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesiones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('prueba_id')
                  ->constrained('pruebas_usabilidad')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->foreignId('participante_id')
                  ->constrained('participantes')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->foreignId('tarea_id')
                  ->constrained('tareas')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            // aplicativo_id es tinyIncrements → unsignedTinyInteger
            $table->unsignedTinyInteger('aplicativo_id');
            $table->foreign('aplicativo_id')
                  ->references('id')->on('cat_aplicativos')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->dateTime('fecha_sesion')->nullable();
            $table->string('moderador')->nullable();

            $table->timestamps();

            // Un participante no puede repetir la misma tarea en el mismo aplicativo
            $table->unique(
                ['participante_id', 'tarea_id', 'aplicativo_id'],
                'uq_sesion_unica'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesiones');
    }
};
