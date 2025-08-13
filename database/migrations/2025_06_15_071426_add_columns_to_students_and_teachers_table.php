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
        Schema::table('students', function (Blueprint $table) {
            $table->float('rate')->default(0);
            $table->integer('number_of_rates')->default(0);
        });
        Schema::table('teachers', function (Blueprint $table) {
            $table->float('rate')->default(0);
            $table->integer('number_of_rates')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
