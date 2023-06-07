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
        Schema::create('token', function (Blueprint $table) {
            $table->bigIncrements('tokenId');
            $table->unsignedBigInteger('maNguoiDung');
            $table->string('token', 255);
            $table->string('refreshToken', 255)->nullable();
            $table->timestamp('tokenExpired')->nullable();
            $table->timestamp('refreshTokenExpired')->nullable();
            $table->foreign('maNguoiDung')->references('maNguoiDung')->on('nguoidung');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token');
    }
};
