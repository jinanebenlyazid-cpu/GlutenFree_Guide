<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('notifications', 'contact_message_id')) {
            Schema::table('notifications', function (Blueprint $table) {
                $column = $table->unsignedBigInteger('contact_message_id')->nullable();

                if (Schema::hasColumn('notifications', 'comment_id')) {
                    $column->after('comment_id');
                }
            });
        }

        DB::statement("ALTER TABLE notifications MODIFY recipe_id BIGINT UNSIGNED NULL");
        DB::statement("ALTER TABLE notifications MODIFY type ENUM('like', 'comment', 'reply', 'contact_reply') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE notifications MODIFY type ENUM('like', 'comment', 'reply') NOT NULL");
        DB::statement("ALTER TABLE notifications MODIFY recipe_id BIGINT UNSIGNED NOT NULL");

        Schema::table('notifications', function (Blueprint $table) {
            if (Schema::hasColumn('notifications', 'contact_message_id')) {
                $table->dropColumn('contact_message_id');
            }
        });
    }
};
