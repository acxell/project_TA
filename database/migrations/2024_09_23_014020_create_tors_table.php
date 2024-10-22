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
        Schema::create('tors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('proker_id');
            $table->string('nama_kegiatan')->unique();
            $table->string('pic');
            $table->string('kepesertaan');
            $table->string('nomor_standar_akreditasi');
            $table->string('penjelasan_standar_akreditasi');
            $table->uuid('coa_id');
            $table->string('latar_belakang');
            $table->string('tujuan');
            $table->string('manfaat_internal');
            $table->string('manfaat_eksternal');
            $table->string('metode_pelaksanaan');
            $table->uuid('user_id');
            $table->uuid('unit_id');
            $table->uuid('satuan_id');
            $table->timestamps();

            $table->foreign('proker_id')->references('id')->on('program_kerjas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('penggunas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tors');
    }
};
