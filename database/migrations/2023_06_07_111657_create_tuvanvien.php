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
        Schema::create('tuvanvien', function (Blueprint $table) {
            $table->bigIncrements('maTvv');
            $table->string('tenTvv', 255);
            $table->string('linkZalo', 255);
            $table->string('soDienThoai', 14);
            $table->string('linkAnh', 500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tuvanvien');
    }
};
