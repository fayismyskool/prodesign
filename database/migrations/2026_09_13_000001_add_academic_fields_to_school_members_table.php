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
        Schema::table('school_members', function (Blueprint $table) {
            $table->string('grade', 50)->nullable()->after('id_number');
            $table->string('section', 20)->nullable()->after('grade');
            $table->string('academic_year', 20)->nullable()->after('section');
            $table->string('board', 50)->nullable()->after('academic_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_members', function (Blueprint $table) {
            $table->dropColumn(['grade', 'section', 'academic_year', 'board']);
        });
    }
};
