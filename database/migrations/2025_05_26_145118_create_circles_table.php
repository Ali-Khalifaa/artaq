<?php

use App\Models\CircleType;
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
        Schema::create('circles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['male', 'female'])->nullable()->comment('جنس الطالب');
            $table->foreignIdFor(CircleType::class)->nullable()->comment('نوع الحلقة');
            $table->time('start_time')->comment('وقت البداية');
            $table->time('end_time')->comment('وقت النهاية');
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circles');
    }
};
