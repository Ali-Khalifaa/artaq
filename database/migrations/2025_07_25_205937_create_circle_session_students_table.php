<?php

use App\Models\Circle;
use App\Models\CircleSession;
use App\Models\Student;
use App\Models\StudentLevelTask;
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
        Schema::create('circle_session_students', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CircleSession::class, 'circle_session_id');
            $table->foreignIdFor(Student::class, 'student_id');
            $table->foreignIdFor(StudentLevelTask::class, 'student_level_task_id');
            $table->boolean("attends")->nullable();
            $table->boolean("is_passed")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circle_session_students');
    }
};
