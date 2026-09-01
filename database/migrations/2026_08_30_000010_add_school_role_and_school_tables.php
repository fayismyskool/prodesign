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
        // 1. Expand the role enum to include 'school'
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('instructor','student','school') NOT NULL DEFAULT 'student'");

        // 2. Add school-specific columns to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('school_name')->nullable()->after('role');
            $table->string('registration_number')->nullable()->after('school_name');
            $table->string('contact_person')->nullable()->after('registration_number');
        });

        // 3. Create school_members table
        Schema::create('school_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('role_in_school', ['teacher', 'student'])->default('student');
            $table->string('id_number')->nullable()->comment('Roll number / Employee ID');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->unique(['school_id', 'user_id']);
            $table->index(['school_id', 'role_in_school']);
        });

        // 4. Create school_course_assignments table
        Schema::create('school_course_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('role_in_school', ['teacher', 'student'])->default('student');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->timestamp('assigned_at')->useCurrent();
            $table->enum('status', ['active', 'revoked'])->default('active');
            $table->timestamps();

            $table->unique(['school_id', 'course_id', 'user_id']);
            $table->index(['school_id', 'status']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_course_assignments');
        Schema::dropIfExists('school_members');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['school_name', 'registration_number', 'contact_person']);
        });

        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('instructor','student') NOT NULL DEFAULT 'student'");
    }
};
