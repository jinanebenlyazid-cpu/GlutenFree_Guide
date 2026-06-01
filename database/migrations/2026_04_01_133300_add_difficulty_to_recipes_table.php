<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('recipes', 'difficulty')) {
            Schema::table('recipes', function (Blueprint $table) {
                $table->enum('difficulty', ['facile', 'moyen', 'difficile'])->default('facile')->after('prep_time');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('recipes', 'difficulty')) {
            Schema::table('recipes', function (Blueprint $table) {
                $table->dropColumn('difficulty');
            });
        }
    }
};
