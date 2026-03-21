<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participantes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('prueba_id')
                  ->constrained('pruebas_usabilidad')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->string('codigo', 10)->comment('Ej: P1, P2, P3');
            $table->string('perfil');
            $table->string('experiencia')->nullable();
            $table->unsignedTinyInteger('edad')->nullable();

            $table->timestamps();

            // Código único por prueba
            $table->unique(['prueba_id', 'codigo'], 'uq_participante_codigo_prueba');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};
