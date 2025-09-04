<?php

use App\Models\City;
use App\Models\Country;
use App\Models\Level;
use App\Models\MemorizationAmount;
use App\Models\MemorizationType;
use App\Models\Nationality;
use App\Models\PreservationMethod;
use App\Models\Track;
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
        Schema::create('parents', function (Blueprint $table) {
            $table->id();

            $table->string('phone')->nullable()->unique();
            $table->string('password')->nullable()->comment('كلمة المرور');
            $table->string('image')->nullable();
            $table->string('email')->nullable();
            $table->string('code')->nullable()->comment('كود ولي الامر ');
            $table->integer('otp_code')->nullable();
            $table->timestamp('code_expired_at')->nullable();
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
        Schema::dropIfExists('parents');
    }
};
