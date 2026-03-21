<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cat_aplicativos', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('nombre', 100)->unique();
            $table->string('url', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cat_aplicativos');
    }
};
