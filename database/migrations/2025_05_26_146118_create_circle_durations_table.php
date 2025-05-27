<?php

use App\Models\Circle;
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
        Schema::create('circle_durations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Circle::class)->nullable()->comment('الحلقة');
            $table->string('day')->comment('اليوم');
            $table->time('start_time')->comment('وقت البداية');
            $table->time('end_time')->comment('وقت النهاية');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circle_durations');
    }
};
