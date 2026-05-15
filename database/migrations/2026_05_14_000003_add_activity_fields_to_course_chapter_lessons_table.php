<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_chapter_lessons', function (Blueprint $table) {
            $table->text('material_required')->nullable()->after('description');
            $table->unsignedTinyInteger('age_min')->nullable()->after('material_required');
            $table->unsignedTinyInteger('age_max')->nullable()->after('age_min');
            $table->string('activity_duration')->nullable()->after('age_max');
        });

        Schema::create('activity_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('course_chapter_lessons')->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name')->nullable();
            $table->string('file_type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_files');

        Schema::table('course_chapter_lessons', function (Blueprint $table) {
            $table->dropColumn(['material_required', 'age_min', 'age_max', 'activity_duration']);
        });
    }
};
