<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('recipes', 'status')) {
            Schema::table('recipes', function (Blueprint $table) {
                $table->enum('status', ['pending', 'approved', 'refused'])->default('pending')->after('user_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('recipes', 'status')) {
            Schema::table('recipes', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
