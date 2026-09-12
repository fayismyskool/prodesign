<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Expand the role enum to include 'teacher' as well as 'school', 'instructor', 'student'
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('instructor','student','school','teacher') NOT NULL DEFAULT 'student'");

        // 2. Add phone_verified_at if not present
        if (!Schema::hasColumn('users', 'phone_verified_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('phone_verified_at')->nullable()->after('phone');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'phone_verified_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('phone_verified_at');
            });
        }

        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('instructor','student','school') NOT NULL DEFAULT 'student'");
    }
};
