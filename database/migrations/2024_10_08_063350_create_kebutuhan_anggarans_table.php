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
        Schema::create('kebutuhan_anggarans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('aktivitas_id');
            $table->string('uraian_aktivitas');
            $table->bigInteger('frekwensi');
            $table->bigInteger('nominal_volume');
            $table->string('satuan_volume');
            $table->bigInteger('harga');
            $table->bigInteger('jumlah');
            $table->timestamps();

            $table->foreign('aktivitas_id')->references('id')->on('aktivitas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kebutuhan_anggarans');
    }
};
