<?php

use App\Models\Admin;
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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mime_type');
            $table->foreignIdFor(Admin::class, 'uploaded_by');
            $table->bigInteger('size');
            $table->string('uploadable_type');
            $table->unsignedBigInteger('uploadable_id');
            $table->string('identifier')->nullable();
            $table->string('url');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     *
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
