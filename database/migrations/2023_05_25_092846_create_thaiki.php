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
        Schema::create('thaiki', function (Blueprint $table) {
            $table->bigIncrements('MaThaiKi');
            $table->string('MaNguoiDung', 20);
            $table->foreign('MaNguoiDung')->references('MaNguoiDung')->on('nguoidung');
            $table->date('NgayQuanHe')->nullable();
            $table->date('NgayTestThuThai')->nullable();
            $table->boolean('KetQuaVangDa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thaiki');
    }
};
