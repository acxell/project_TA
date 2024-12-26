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
        Schema::create('lpjs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kegiatan_id');
            $table->uuid('proker_id');
            $table->longText('penjelasan_kegiatan');
            $table->bigInteger('jumlah_peserta_undangan');
            $table->bigInteger('jumlah_peserta_hadir');
            $table->longText('hasil_kegiatan');
            $table->longText('perbaikan_kegiatan');
            $table->string('status');
            $table->bigInteger('total_belanja')->nullable();
            $table->uuid('user_id');
            $table->uuid('unit_id');
            $table->uuid('satuan_id');
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
        Schema::dropIfExists('lpjs');
    }
};
