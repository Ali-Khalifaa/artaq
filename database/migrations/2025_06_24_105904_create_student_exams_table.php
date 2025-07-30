<?php

use App\Models\Admin;
use App\Models\Level;
use App\Models\Student;
use App\Models\Track;
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
        Schema::create('student_exams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('degree')->default(0);
            $table->string('link')->nullable();
            $table->string('status')->default("pending");//enums status
            $table->timestamp('date_time');
            $table->foreignIdFor(Student::class, 'student_id')->nullable();
            $table->foreignIdFor(Level::class, 'level_id')->nullable();
            $table->foreignIdFor(Track::class, 'track_id')->nullable();
            $table->foreignIdFor(Admin::class, 'admin_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_exams');
    }
};
