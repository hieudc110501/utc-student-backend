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
        Schema::create('nhatky', function (Blueprint $table) {
            $table->bigIncrements('maNhatKy');
            $table->unsignedBigInteger('maNguoiDung');
            $table->integer('thoiGian');
            $table->foreign('maNguoiDung')->references('maNguoiDung')->on('nguoidung');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhatky');
    }
};
