<?php

use App\Models\Ayah;
use App\Models\IntensiveStudy;
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
        Schema::create('intensive_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(IntensiveStudy::class, 'intensive_study_id')->nullable();
            $table->integer("number_of_mins")->nullable();
            $table->dateTime("date")->nullable();
            $table->boolean("status")->default(0);
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
        Schema::dropIfExists('intensive_sessions');
    }
};
