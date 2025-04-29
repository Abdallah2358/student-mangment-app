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
        Schema::create('group_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained();
            $table->foreignId('student_id')->constrained();
            $table->foreignId('teacher_id')->constrained();
            $table->date('joined_at')->nullable();
            $table->date('left_at')->nullable();
            $table->tinyInteger('status')->default(GraduationStatusEnum::ACTIVE); // 0: active, 1: inactive, graduated
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_student');
    }
};
