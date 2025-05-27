<?php

use App\Models\City;
use App\Models\Country;
use App\Models\Level;
use App\Models\MemorizationAmount;
use App\Models\MemorizationType;
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->date('birth_date')->nullable();
            $table->foreignIdFor(Level::class)->nullable()->constrained()->nullOnDelete();
            $table->string('phone')->unique();
            $table->string('guardian_phone')->unique()->nullable()->comment('جوال ولى امره');
            $table->foreignIdFor(MemorizationType::class)->nullable()->constrained()->nullOnDelete()->comment('نوع الحفظ');
            $table->enum('gender', ['male', 'female'])->nullable()->comment('جنس الطالب');
            $table->foreignIdFor(Nationality::class)->nullable()->constrained()->nullOnDelete()->comment('الجنسية');
            $table->foreignIdFor(Country::class)->nullable()->constrained()->nullOnDelete()->comment('البلد');
            $table->foreignIdFor(City::class)->nullable()->constrained()->nullOnDelete()->comment('المدينة');
            $table->foreignIdFor(MemorizationAmount::class)->nullable()->constrained()->nullOnDelete()->comment('مقدار الحفظ');
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
        Schema::dropIfExists('students');
    }
};
