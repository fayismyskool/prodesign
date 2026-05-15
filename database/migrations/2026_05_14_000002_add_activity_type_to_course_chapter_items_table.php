<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Doctrine DBAL doesn't support enum modification; use raw SQL instead
        DB::statement("ALTER TABLE course_chapter_items MODIFY COLUMN type ENUM('lesson', 'document', 'quiz', 'live', 'activity') NOT NULL DEFAULT 'lesson'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE course_chapter_items MODIFY COLUMN type ENUM('lesson', 'document', 'quiz', 'live') NOT NULL DEFAULT 'lesson'");
    }
};
