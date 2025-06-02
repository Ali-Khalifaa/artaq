<?php

use App\Models\Teacher;
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
        Schema::create('teacher_qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Teacher::class)->nullable()->comment('المعلم');
            $table->string('name')->nullable()->comment('المؤهل العلمي');
            $table->string('institution')->nullable()->comment('المؤسسة التعليمية');
            $table->date('graduation_date')->nullable()->comment('تاريخ التخرج');
            $table->string('image')->nullable();
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
