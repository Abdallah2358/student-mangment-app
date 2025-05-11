<?php

use App\Enums\GraduationStatusEnum;
use App\Enums\GuardianRelationEnum;
use App\Enums\GenderEnum;
use App\Models\Teacher;
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(Teacher::class);
            $table->string('phone')->nullable();
            $table->string('guardian_name');
            $table->string('guardian_phone');
            $table->tinyInteger('guardian_relation')->default(GuardianRelationEnum::Father); // 1: father, 2: mother, 3: other
            $table->string('address')->nullable();
            $table->string('class');
            $table->boolean('gender')->default(GenderEnum::MALE); // 0: male , 1:female
            $table->date('birth_date')->nullable();
            $table->date('enrollment_date')->nullable();
            $table->string('notes')->nullable();
            $table->tinyInteger('status')->default(GraduationStatusEnum::ACTIVE); // 0: active, 1: inactive, graduated
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
