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
        Schema::create('ketquatest', function (Blueprint $table) {
            $table->bigIncrements('MaKetQuaTest');
            $table->string('MaHopTest', 500);
            $table->foreign('MaHopTest')->references('MaHopTest')->on('hoptest');
            $table->boolean('LoaiQue')->nullable();
            $table->integer('LanThu')->nullable();
            $table->dateTime('ThoiGian')->nullable();
            $table->integer('KetQua')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ketquatest');
    }
};
