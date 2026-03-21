<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cat_severidades', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('nombre', 20)->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cat_severidades');
    }
};
