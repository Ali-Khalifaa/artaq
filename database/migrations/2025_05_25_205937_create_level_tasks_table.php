<?php

use App\Models\Ayah;
use App\Models\Level;
use App\Models\PreservationMethod;
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
        Schema::create('level_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Level::class, 'level_id');
            $table->foreignIdFor(Surah::class, 'from_surah_id');
            $table->foreignIdFor(Surah::class, 'to_surah_id');
            $table->foreignIdFor(Ayah::class, 'from_ayah_id');
            $table->foreignIdFor(Ayah::class, 'to_ayah_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_tasks');
    }
};
