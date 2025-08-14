<?php

use App\Models\Ayah;
use App\Models\PreservationMethod;
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
        Schema::create('intensive_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Student::class, 'student_id')->nullable();
            $table->foreignIdFor(Teacher::class, 'teacher_id')->nullable();
            $table->foreignIdFor(PreservationMethod::class, 'preservation_method_id')->nullable();
            $table->time("time")->nullable();
            $table->string("status")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intensive_requests');
    }
};
