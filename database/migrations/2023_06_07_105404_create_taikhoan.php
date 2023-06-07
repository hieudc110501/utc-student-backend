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
        Schema::create('taikhoan', function (Blueprint $table) {
            $table->string('maTaiKhoan', 255)->primary();
            $table->unsignedBigInteger('maPhanQuyen');
            $table->string('tenTaiKhoan', 14)->unique();
            $table->string('matKhau', 255);
            $table->foreign('maPhanQuyen')->references('maPhanQuyen')->on('phanquyen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taikhoan');
    }
};
