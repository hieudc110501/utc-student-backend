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
        Schema::create('nguoidung', function (Blueprint $table) {
            $table->bigIncrements('maNguoiDung');
            $table->string('maTaiKhoan', 255)->unique();
            $table->unsignedBigInteger('maTvv')->nullable();
            $table->string('tenNguoiDung', 255);
            $table->integer('namSinh')->nullable();
            $table->integer('chieuCao')->nullable();
            $table->integer('canNang')->nullable();
            $table->foreign('maTaiKhoan')->references('maTaiKhoan')->on('taikhoan');
            $table->foreign('maTvv')->references('maTvv')->on('tuvanvien');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nguoidung');
    }
};
