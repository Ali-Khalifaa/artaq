<?php

use App\Models\Ayah;
use App\Models\Level;
use App\Models\Student;
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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->morphs("rated");// اللي تم تقييمه
            $table->morphs("rateby");//الشخص اللي قيم
            $table->morphs("model"); // الحاجة اللي تم التقيم عليها
            $table->integer("rate");
            $table->text("comment")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
