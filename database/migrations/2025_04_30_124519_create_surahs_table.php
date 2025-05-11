<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Surah;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surahs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم السورة
            $table->unsignedInteger('ayah_count'); // عدد الآيات
            $table->timestamps();
        });

        $filePath = storage_path('app/public/soras.csv'); // تأكد أن الملف في هذا المسار
        if (!File::exists($filePath)) {
            throw new \Exception("CSV file not found at: $filePath");
        }
        $rows = array_map('str_getcsv', file($filePath));
        $header = array_map('trim', array_shift($rows)); // أول سطر = رأس الجدول
        foreach ($rows as $row) {
            $data = array_combine($header, $row);
            Surah::create([
                'name' => $data['name'], // عدّل إذا كان اسم العمود مختلف
                'ayah_count' => $data['ayaCount'],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surahs');
    }
};
