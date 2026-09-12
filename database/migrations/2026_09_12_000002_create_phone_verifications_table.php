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
        Schema::create('phone_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->index();
            $table->string('otp');
            $table->string('token', 100)->nullable()->unique();
            $table->enum('type', ['registration', 'login'])->default('registration');
            $table->tinyInteger('attempts')->default(0);
            $table->timestamp('expires_at');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->index(['phone', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phone_verifications');
    }
};
