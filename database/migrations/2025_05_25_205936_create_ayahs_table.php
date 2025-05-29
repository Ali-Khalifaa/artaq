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
            $table->integer('number')->comment('رقم الاية بالنسبة للقران كله'); // Global ayah number
            $table->text('text');
            $table->text('text_normalized')->comment('النص بدون تشكيل'); // Normalized text without diacritics
            $table->integer('number_in_surah')->comment('رقم الاية بالنسبة للسورة'); // Ayah number within the Surah
            $table->integer('juz')->comment('رقم الجزء'); // Juz number
            $table->integer('manzil')->comment('رقم المنزلة'); // Manzil number
            $table->integer('page')->comment('رقم الصفحة'); // Page number
            $table->integer('ruku')->comment('رقم الركعة'); // Ruku number
            $table->integer('hizb_quarter')->comment('ربع الحزب'); // Hizb quarter number
            $table->tinyInteger('sajda')->default(0)->comment('السجده'); // 0 = No Sajda, 1 = Sajda recommended,2 = Sajda obligatory
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
