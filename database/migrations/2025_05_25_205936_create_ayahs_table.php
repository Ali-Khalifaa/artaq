<?php

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
        Schema::create('ayahs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Surah::class, 'surah_id');
            $table->integer('number'); // Global ayah number
            $table->text('text');
            $table->integer('number_in_surah');
            $table->integer('juz');
            $table->integer('manzil');
            $table->integer('page');
            $table->integer('ruku');
            $table->integer('hizb_quarter');
            $table->tinyInteger('sajda')->default(0); // 0 = No Sajda, 1 = Sajda recommended,2 = Sajda obligatory
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ayahs');
    }
};
