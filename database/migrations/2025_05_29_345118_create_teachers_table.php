<?php

use App\Models\Admin;
use App\Models\City;
use App\Models\Country;
use App\Models\Nationality;
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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone')->unique();
            $table->string('id_number')->unique()->comment('رقم الهوية');
            $table->enum('gender', ['male', 'female'])->nullable()->comment('جنس المعلم');
            $table->foreignIdFor(Admin::class)->nullable()->comment('المدير المباشر');
            $table->foreignIdFor(Nationality::class)->nullable()->comment('الجنسية');
            $table->foreignIdFor(Country::class)->nullable()->comment('البلد');
            $table->foreignIdFor(City::class)->nullable()->comment('المدينة');
            $table->string('password')->nullable()->comment('كلمة المرور');
            $table->string('image')->nullable();
            $table->boolean('status')->default(true);

            $table->date('birth_date')->nullable();
            $table->string('email')->unique()->nullable()->comment('البريد الإلكتروني');
            $table->integer('juz_count')->default(0)->comment('عدد الأجزاء التي حفظها المعلم');
            $table->integer('experience_years')->default(0)->comment('سنوات الخبرة');
            $table->integer('Quran_licenses')->default(0)->comment('عدد الإجازات القرآنية');
            $table->decimal('salary', 10, 2)->default(0)->comment('الراتب');
            $table->string('cv')->nullable()->comment('السيرة الذاتية');
            $table->string('code')->nullable()->comment('كود المعلم');

            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
