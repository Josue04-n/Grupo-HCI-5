<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pruebas_usabilidad', function (Blueprint $table) {
            $table->id();

            // Relación con users (tabla que genera Laravel/Breeze)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            // Catálogos: tinyIncrements requiere unsignedTinyInteger en FK
            $table->unsignedTinyInteger('metodo_id');
            $table->foreign('metodo_id')
                  ->references('id')->on('cat_metodos')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->unsignedTinyInteger('estado_id');
            $table->foreign('estado_id')
                  ->references('id')->on('cat_estados_prueba')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->string('nombre');
            $table->string('producto');
            $table->string('modulo')->nullable();
            $table->text('objetivo');
            $table->text('perfil_usuarios')->nullable();
            $table->date('fecha')->nullable();
            $table->string('lugar')->nullable();
            $table->string('duracion', 100)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pruebas_usabilidad');
    }
};
