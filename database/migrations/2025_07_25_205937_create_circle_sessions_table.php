<?php

use App\Models\Circle;
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
        Schema::create('circle_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Circle::class, 'circle_id');
            $table->foreignIdFor(Teacher::class, 'teacher_id');
            $table->string("status")->default("pending");
            $table->string("day");
            $table->string("number_of_minutes")->nullable();
            $table->dateTime("date");
            $table->time("start_time");
            $table->time("end_time");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circle_sessions');
    }
};
