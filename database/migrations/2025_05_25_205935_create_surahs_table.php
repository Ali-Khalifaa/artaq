<?php

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
        Schema::create('surahs', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->unique();
            $table->string('name')->comment('الاسم بالتشكيل'); // Arabic name4
            $table->string('normalized_name')->comment('الاسم بدون تشكيل'); // Normalized Arabic name
            $table->string('english_name')->comment('الاسم بالانجليزية'); // English name
            $table->string('english_name_translation')->comment('ترجمة الاسم بالانجليزية'); // English name translation
            $table->string('revelation_type')->comment('نوع النزول'); // Revelation type (Meccan or Medinan)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surahs');
    }
};
