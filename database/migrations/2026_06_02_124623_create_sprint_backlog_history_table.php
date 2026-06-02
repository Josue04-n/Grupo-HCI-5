<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sprint_backlog_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aplicativo_id')->constrained('cat_aplicativos')->onDelete('cascade');
            $table->longText('content');
            $table->string('version_name')->nullable(); // Para que el usuario le ponga un nombre si quiere
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sprint_backlog_history');
    }
};
