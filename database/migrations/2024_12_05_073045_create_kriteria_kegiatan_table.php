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
        Schema::create('kriteria_kegiatan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kegiatan_id');
            $table->uuid('kriteria_id');
            $table->uuid('subkriteria_id')->nullable();
            $table->double('nilai')->nullable();
            $table->timestamps();

            $table->foreign('kegiatan_id')->references('id')->on('kegiatans')->cascadeOnDelete();
            $table->foreign('kriteria_id')->references('id')->on('kriterias')->cascadeOnDelete();
            $table->foreign('subkriteria_id')->references('id')->on('subkriterias')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria_kegiatan');
    }
};
