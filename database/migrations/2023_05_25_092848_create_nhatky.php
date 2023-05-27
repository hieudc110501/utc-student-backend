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
            $table->bigIncrements('MaNhatKy');
            $table->string('MaNguoiDung', 20);
            $table->foreign('MaNguoiDung')->references('MaNguoiDung')->on('nguoidung');
            $table->dateTime('NgayQuanHe')->nullable();
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
