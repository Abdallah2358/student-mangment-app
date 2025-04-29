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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->foreignId('teacher_id')->constrained();
            $table->string('class');
            $table->string('subject');
            $table->string('batch'); // e.g., "2025-2026"
            $table->string('group_code')->unique(); // Unique code for the group
            $table->integer('fees_per_class')->default(0); // Fees for the group
            $table->integer('number_of_sessions_given')->default(0); // Total number of sessions given to group in the batch
            $table->integer('discount')->default(0); // Discount on the fees
            $table->time('start_time');
            $table->string('days'); // Comma-separated days of the week (e.g., "Monday,Wednesday,Friday")
            $table->string('location')->nullable(); // Location of the class
            $table->tinyInteger('status')->default(GraduationStatusEnum::ACTIVE); // 0: active, 1: inactive, graduated
            $table->string('description')->nullable();
            $table->timestamps();

            // Ideas 
            // $table->string('group_type')->default('regular'); // regular, crash course, etc.
            // $table->string('group_category')->default('academic'); // academic, extracurricular, etc.
            // $table->string('group_level')->default('beginner'); // beginner, intermediate, advanced
            // $table->integer('max_students')->default(30); // Maximum number of students allowed in the group
            // $table->integer('current_students')->default(0); // Current number of students in the group
            // $table->integer('duration')->default(60); // Duration of each class in minutes
            // $table->integer('total_classes')->default(0); // Total number of classes in the batch
            // $table->integer('classes_attended')->default(0); // Number of classes attended by the group
            // $table->integer('classes_missed')->default(0); // Number of classes missed by the group
            // $table->integer('paid_fees')->default(0); // Fees paid by the students
            // $table->time('end_time');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
