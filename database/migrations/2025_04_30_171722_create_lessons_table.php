<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\{Group, Teacher, Student};

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Teacher::class);
            $table->foreignIdFor(Group::class)->nullable(); // null if 1-on-1
            $table->foreignIdFor(Student::class)->nullable(); // set only for 1-on-1
            $table->tinyInteger('type')->default(LessonTypeEnum::GROUP);
            $table->string('topic')->nullable();
            $table->date('date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('duration_minutes')->nullable(); // for reporting/billing
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
