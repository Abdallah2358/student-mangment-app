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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('guardian_name');
            $table->string('guardian_phone');
            $table->integer('guardian_relation')->default(1);// 1: father, 2: mother, 3: other
            $table->string('address')->nullable();
            $table->string('class');
            $table->integer('sex')->default(0); // 0: male , 1:female
            $table->string('notes')->nullable();
            $table->integer('status')->default(1); // 0: active, 1:inactive, graduated
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
