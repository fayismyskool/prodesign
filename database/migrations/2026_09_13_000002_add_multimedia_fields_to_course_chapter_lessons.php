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
        Schema::table('course_chapter_lessons', function (Blueprint $table) {
            $table->string('topic_category', 150)->nullable()->after('title');
            $table->text('video_url')->nullable()->after('file_path');
            $table->text('audio_path')->nullable()->after('video_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_chapter_lessons', function (Blueprint $table) {
            $table->dropColumn(['topic_category', 'video_url', 'audio_path']);
        });
    }
};
