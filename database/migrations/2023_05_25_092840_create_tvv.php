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
        Schema::create('tvv', function (Blueprint $table) {
            $table->bigIncrements('MaTVV');
            $table->string('TenTVV', 255);
            $table->string('Link', 1000)->nullable();
            $table->string('SoDienThoai', 255)->nullable();
            $table->string('Anh', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tvv');
    }
};
