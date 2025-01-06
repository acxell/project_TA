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
        Schema::create('rincian_lpjs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('lpj_id');
            $table->date('waktu_belanja');
            $table->bigInteger('harga');
            $table->longText('keterangan');
            $table->string('bukti');
            $table->timestamps();

            $table->foreign('lpj_id')->references('id')->on('lpjs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_lpjs');
    }
};
