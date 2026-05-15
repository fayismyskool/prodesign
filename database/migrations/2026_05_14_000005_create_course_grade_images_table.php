<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_grade_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_id')->constrained('course_grades')->onDelete('cascade');
            $table->string('image_path');
            $table->string('image_name')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_grade_images');
    }
};
