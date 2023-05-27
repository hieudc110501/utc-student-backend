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
        Schema::create('hoptest', function (Blueprint $table) {
            $table->string('MaHopTest', 500)->primary();
            $table->string('MaNguoiDung', 20);
            $table->foreign('MaNguoiDung')->references('MaNguoiDung')->on('nguoidung');
            $table->integer('SoLuong')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoptest');
    }
};
