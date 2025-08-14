<?php

use App\Models\Ayah;
use App\Models\Student;
use App\Models\Surah;
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
        Schema::create('free_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Student::class, 'student_id')->nullable();
            $table->foreignIdFor(Teacher::class, 'teacher_id')->nullable();
            $table->integer("number_of_mins")->nullable();
            $table->string("status")->nullable();

            $table->foreignIdFor(Surah::class, 'from_surah_id')->nullable();
            $table->foreignIdFor(Surah::class, 'to_surah_id')->nullable();
            $table->foreignIdFor(Ayah::class, 'from_ayah_id')->nullable();
            $table->foreignIdFor(Ayah::class, 'to_ayah_id')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_sessions');
    }
};
