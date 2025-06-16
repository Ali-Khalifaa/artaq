<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Ayah;
use App\Models\Surah;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('level_tasks', function (Blueprint $table) {
            $table->foreignIdFor(Surah::class, 'review_from_surah_id')->nullable();
            $table->foreignIdFor(Surah::class, 'review_to_surah_id')->nullable();
            $table->foreignIdFor(Ayah::class, 'review_from_ayah_id')->nullable();
            $table->foreignIdFor(Ayah::class, 'review_to_ayah_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('level_tasks', function (Blueprint $table) {
            $table->dropForeign(['review_from_surah_id']);
            $table->dropColumn('review_from_surah_id');
            $table->dropForeign(['review_to_surah_id']);
            $table->dropColumn('review_to_surah_id');
            $table->dropForeign(['review_from_ayah_id']);
            $table->dropColumn('review_from_ayah_id');
            $table->dropForeign(['review_to_ayah_id']);
            $table->dropColumn('review_to_ayah_id');
        });
    }
};
