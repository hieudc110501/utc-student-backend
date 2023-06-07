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
        Schema::create('cautraloi', function (Blueprint $table) {
            $table->bigIncrements('maCauTraLoi');
            $table->unsignedBigInteger('maNhatKy');
            $table->integer('maCauHoi');
            $table->string('cauTraLoi', 1000);
            $table->foreign('maNhatKy')->references('maNhatKy')->on('nhatky');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cautraloi');
    }
};
