<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_grades', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('course_id')->nullable(); // null = global grade
            $table->unsignedBigInteger('instructor_id')->nullable();
            $table->integer('order')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::table('course_chapters', function (Blueprint $table) {
            $table->foreignId('grade_id')->nullable()->after('course_id')
                  ->constrained('course_grades')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('course_chapters', function (Blueprint $table) {
            $table->dropForeign(['grade_id']);
            $table->dropColumn('grade_id');
        });

        Schema::dropIfExists('course_grades');
    }
};
