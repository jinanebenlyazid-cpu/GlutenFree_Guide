<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('contact_messages', 'user_id')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            });
        }
        if (!Schema::hasColumn('contact_messages', 'name')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->string('name')->after('user_id');
            });
        }
        if (!Schema::hasColumn('contact_messages', 'email')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->string('email')->after('name');
            });
        }
        if (!Schema::hasColumn('contact_messages', 'subject')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->string('subject')->after('email');
            });
        }
        if (!Schema::hasColumn('contact_messages', 'message')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->text('message')->after('subject');
            });
        }
        if (!Schema::hasColumn('contact_messages', 'status')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->string('status')->default('open')->after('message');
            });
        }
        if (!Schema::hasColumn('contact_messages', 'reply')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->text('reply')->nullable()->after('status');
            });
        }
        if (!Schema::hasColumn('contact_messages', 'replied_by')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->foreignId('replied_by')->nullable()->after('reply')->constrained('users')->nullOnDelete();
            });
        }
        if (!Schema::hasColumn('contact_messages', 'replied_at')) {
            Schema::table('contact_messages', function (Blueprint $table) {
                $table->timestamp('replied_at')->nullable()->after('replied_by');
            });
        }
    }

    public function down(): void
    {
        $columns = array_values(array_filter([
            Schema::hasColumn('contact_messages', 'name') ? 'name' : null,
            Schema::hasColumn('contact_messages', 'email') ? 'email' : null,
            Schema::hasColumn('contact_messages', 'subject') ? 'subject' : null,
            Schema::hasColumn('contact_messages', 'message') ? 'message' : null,
            Schema::hasColumn('contact_messages', 'status') ? 'status' : null,
            Schema::hasColumn('contact_messages', 'reply') ? 'reply' : null,
            Schema::hasColumn('contact_messages', 'replied_at') ? 'replied_at' : null,
        ]));

        Schema::table('contact_messages', function (Blueprint $table) {
            if (Schema::hasColumn('contact_messages', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
            if (Schema::hasColumn('contact_messages', 'replied_by')) {
                $table->dropConstrainedForeignId('replied_by');
            }
        });

        if ($columns) {
            Schema::table('contact_messages', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};
