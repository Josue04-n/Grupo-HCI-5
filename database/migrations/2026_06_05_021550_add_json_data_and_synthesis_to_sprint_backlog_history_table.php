<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sprint_backlog_history', function (Blueprint $table) {
            if (!Schema::hasColumn('sprint_backlog_history', 'json_data')) {
                $table->json('json_data')->nullable()->after('content');
            }
            if (!Schema::hasColumn('sprint_backlog_history', 'synthesis')) {
                $table->text('synthesis')->nullable()->after('json_data');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sprint_backlog_history', function (Blueprint $table) {
            $table->dropColumn(['json_data', 'synthesis']);
        });
    }
};
