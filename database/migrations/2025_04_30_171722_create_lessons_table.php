<?php

use App\Enums\LessonTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\{Group, Teacher, Student, Surah};

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
            $table->string('tajwed_rule')->nullable();

            $table->foreignIdFor(Surah::class, 'read_sora_start_id')->nullable();
            $table->unsignedSmallInteger('read_aya_start')->nullable();
            $table->foreignIdFor(Surah::class, 'read_sora_end_id')->nullable();
            $table->unsignedSmallInteger('read_aya_end')->nullable();

            $table->foreignIdFor(Surah::class, 'hafz_sora_start_id')->nullable();
            $table->unsignedSmallInteger('hafz_aya_start')->nullable();
            $table->foreignIdFor(Surah::class, 'hafz_sora_end_id')->nullable();
            $table->unsignedSmallInteger('hafz_aya_end')->nullable();

            $table->foreignIdFor(Surah::class, 'review_n_sora_start_id')->nullable();
            $table->unsignedSmallInteger('review_n_aya_start')->nullable();
            $table->foreignIdFor(Surah::class, 'review_n_sora_end_id')->nullable();
            $table->unsignedSmallInteger('review_n_aya_end')->nullable();

            $table->foreignIdFor(Surah::class, 'review_f_sora_start_id')->nullable();
            $table->unsignedSmallInteger('review_f_aya_start')->nullable();
            $table->foreignIdFor(Surah::class, 'review_f_sora_end_id')->nullable();
            $table->unsignedSmallInteger('review_f_aya_end')->nullable();

            $table->string('akyda')->nullable();
            $table->string('hadyth')->nullable();
            $table->string('fiqha')->nullable();
            $table->string('akhlak')->nullable();

            $table->decimal('fee', 8, 2)->nullable(); // for reporting/billing

            // $table->integer('duration_minutes')->nullable(); // for reporting/billing
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
