<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('prueba_id')
                  ->constrained('pruebas_usabilidad')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->string('codigo', 10)->comment('Ej: T1, T2, T3');
            $table->text('escenario');
            $table->text('resultado_esperado')->nullable();
            $table->string('metrica_principal')->nullable();
            $table->string('criterio_exito')->nullable();
            $table->text('guion_texto')->nullable()
                  ->comment('Texto que lee el moderador al participante');
            $table->text('pregunta_seguimiento')->nullable();

            $table->timestamps();

            // Código único por prueba (T1 puede existir en varias pruebas)
            $table->unique(['prueba_id', 'codigo'], 'uq_tarea_codigo_prueba');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
