<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('observaciones', function (Blueprint $table) {
            $table->id();

            // Relación 1:1 con sesiones (unique garantiza una sola observación por sesión)
            $table->foreignId('sesion_id')
                  ->unique()
                  ->constrained('sesiones')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            // severidad_id: tinyIncrements → unsignedTinyInteger
            $table->unsignedTinyInteger('severidad_id')->nullable();
            $table->foreign('severidad_id')
                  ->references('id')->on('cat_severidades')
                  ->nullOnDelete()
                  ->cascadeOnUpdate();

            $table->enum('exito', [
                'Sí, sin ayuda',
                'Sí, con poca ayuda',
                'Sí, con mucha ayuda',
                'No completó',
            ])->nullable();

            $table->unsignedTinyInteger('eficacia')->nullable()
                  ->comment('0 = no completó | 1 = mucha ayuda | 2 = poca ayuda | 3 = sin ayuda');

            $table->unsignedTinyInteger('eficiencia')->nullable()
                  ->comment('1 = muy ineficiente | 2 = poco eficiente | 3 = eficiente | 4 = muy eficiente');

            $table->decimal('satisfaccion', 3, 1)->nullable()
                  ->comment('Escala Likert 1.0 – 5.0');

            $table->unsignedInteger('tiempo_seg')->nullable()
                  ->comment('Segundos empleados en completar la tarea');

            $table->unsignedInteger('errores')->default(0)
                  ->comment('Clics erróneos y retrocesos durante la tarea');

            $table->text('comentarios')->nullable();
            $table->text('problema_detectado')->nullable();
            $table->text('mejora_propuesta')->nullable();

            $table->timestamps();

            // Índices para consultas frecuentes del dashboard
            $table->index('severidad_id', 'idx_obs_severidad');
            $table->index('eficacia',     'idx_obs_eficacia');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('observaciones');
    }
};
