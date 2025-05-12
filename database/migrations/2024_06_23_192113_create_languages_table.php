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
        Schema::dropIfExists('sys_language_translations');
        Schema::dropIfExists('sys_languages');
        Schema::create('sys_languages', function (Blueprint $table) {
            $table->id();
            $table->string('code' , 10);
            $table->string('flag')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
        // for all system
        Schema::create('sys_language_translations', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->string('locale' , 10);
            $table->string('title');
            $table->longText('description')->nullable();
            $table->unique(['model_id' , 'model_type' ,'locale']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_language_translations');
        Schema::dropIfExists('sys_languages');
    }
};
