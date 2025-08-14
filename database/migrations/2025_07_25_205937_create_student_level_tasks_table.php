<?php

use App\Models\Ayah;
use App\Models\Circle;
use App\Models\Level;
use App\Models\Student;
use App\Models\StudentCircle;
use App\Models\Surah;
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
        Schema::create('student_level_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(StudentCircle::class, 'student_circle_id');
            $table->foreignIdFor(Circle::class, 'circle_id');
            $table->foreignIdFor(Student::class, 'student_id');
            $table->foreignIdFor(Level::class, 'level_id');
            $table->foreignIdFor(Surah::class, 'from_surah_id');
            $table->foreignIdFor(Surah::class, 'to_surah_id');
            $table->foreignIdFor(Ayah::class, 'from_ayah_id');
            $table->foreignIdFor(Ayah::class, 'to_ayah_id');

            $table->foreignIdFor(Surah::class, 'review_from_surah_id')->nullable();
            $table->foreignIdFor(Surah::class, 'review_to_surah_id')->nullable();
            $table->foreignIdFor(Ayah::class, 'review_from_ayah_id')->nullable();
            $table->foreignIdFor(Ayah::class, 'review_to_ayah_id')->nullable();

            $table->boolean("status")->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_level_tasks');
    }
};
