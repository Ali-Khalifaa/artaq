<?php

use App\Models\Teacher;
use App\Models\TeacherBadge;
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
        Schema::create('teacher_badge_teacher', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Teacher::class, 'teacher_id');
            $table->foreignIdFor(TeacherBadge::class, 'teacher_badge_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_badge_teacher');
    }
};
