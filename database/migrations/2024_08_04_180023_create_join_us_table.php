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
        Schema::create('join_us', function (Blueprint $table) {
            $table->id();
            $table->string('facebook')->default('#');
            $table->string('twitter')->default('#');
            $table->string('instagram')->default('#');
            $table->string('linkedin')->default('#');
            $table->string('youtube')->default('#');
            $table->string('android_app_client')->default('#');
            $table->string('ios_app_client')->default('#');
            $table->string('android_app_teacher')->default('#');
            $table->string('ios_app_teacher')->default('#');
            $table->string('phone')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('join_us');
    }
};
