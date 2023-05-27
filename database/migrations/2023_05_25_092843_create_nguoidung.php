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
            $table->string('MaNguoiDung', 20)->primary();
            $table->unsignedBigInteger('MaTVV')->nullable();
            $table->foreign('MaTVV')->references('MaTVV')->on('tvv');
            $table->string('TenNguoiDung', 255);
            $table->string('MatKhau', 255)->nullable();
            $table->integer('NamSinh');
            $table->integer('ChieuCao')->nullable();
            $table->integer('CanNang')->nullable();
            $table->date('NgayBatDau');
            $table->integer('TBNKN');
            $table->integer('SNCK');
            $table->integer('SNCT');
            $table->integer('CKDN')->nullable();
            $table->integer('CKNN')->nullable();
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
