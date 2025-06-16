<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\City;
use App\Models\Country;
use App\Models\Nationality;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female'])->default('male')->comment('جنس المدير');
            $table->string('id_number')->nullable()->comment('رقم الهوية');
            $table->foreignIdFor(Nationality::class)->nullable()->comment('الجنسية');
            $table->foreignIdFor(Country::class)->nullable()->comment('البلد');
            $table->foreignIdFor(City::class)->nullable()->comment('المدينة');
            $table->date('birth_date')->nullable();
            $table->integer('juz_count')->default(0)->comment('عدد الأجزاء التي حفظها المعلم');
            $table->integer('experience_years')->default(0)->comment('سنوات الخبرة');
            $table->integer('Quran_licenses')->default(0)->comment('عدد الإجازات القرآنية');
            $table->decimal('salary', 10, 2)->default(0)->comment('الراتب');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('id_number');
            $table->dropForeign(['nationality_id']);
            $table->dropColumn('nationality_id');
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
            $table->dropColumn('birth_date');
            $table->dropColumn('juz_count');
            $table->dropColumn('experience_years');
            $table->dropColumn('Quran_licenses');
            $table->dropColumn('salary');
        });
    }
};
