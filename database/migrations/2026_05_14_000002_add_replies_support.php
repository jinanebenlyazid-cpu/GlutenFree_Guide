<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add parent_id to comments (for threaded replies)
        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('parent_id')
                  ->nullable()
                  ->after('recipe_id')
                  ->constrained('comments')
                  ->cascadeOnDelete();
        });

        // Add comment_id to notifications (to link to the specific comment)
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('comment_id')->nullable()->after('recipe_id');
        });

        // Extend the type enum to include 'reply'
        DB::statement("ALTER TABLE notifications MODIFY type ENUM('like', 'comment', 'reply') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE notifications MODIFY type ENUM('like', 'comment') NOT NULL");
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('comment_id');
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
