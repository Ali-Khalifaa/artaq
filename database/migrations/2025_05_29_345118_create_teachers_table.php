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
            $table->enum('gender', ['male', 'female'])->nullable()->comment('جنس الطالب');
            $table->foreignIdFor(Admin::class)->nullable()->comment('المدير المباشر');
            $table->foreignIdFor(Nationality::class)->nullable()->comment('الجنسية');
            $table->foreignIdFor(Country::class)->nullable()->comment('البلد');
            $table->foreignIdFor(City::class)->nullable()->comment('المدينة');
            $table->string('password')->nullable()->comment('كلمة المرور');
            $table->string('image')->nullable();
            $table->boolean('status')->default(true);
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
