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
        Schema::create('pendanaans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kegiatan_id');
            $table->string('bukti_transfer', 100);
            $table->bigInteger('besaran_transfer');
            $table->uuid('user_id');
            $table->uuid('unit_id');
            $table->timestamps();

            $table->foreign('kegiatan_id')->references('id')->on('kegiatans')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('penggunas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendanaans');
    }
};
