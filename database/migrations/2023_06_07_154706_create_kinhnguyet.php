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
        Schema::create('kinhnguyet', function (Blueprint $table) {
            $table->bigIncrements('maKinhNguyet');
            $table->unsignedBigInteger('maNguoiDung');
            $table->integer('tbnkn');
            $table->integer('ckdn')->nullable();
            $table->integer('cknn')->nullable();
            $table->integer('snck');
            $table->integer('snct');
            $table->integer('ngayBatDau');
            $table->integer('ngayKetThuc');
            $table->integer('ngayBatDauKinh');
            $table->integer('ngayKetThucKinh');
            $table->integer('ngayBatDauTrung');
            $table->integer('ngayKetThucTrung');
            $table->integer('trangThai');
            $table->foreign('maNguoiDung')->references('maNguoiDung')->on('nguoidung');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kinhnguyet');
    }
};
