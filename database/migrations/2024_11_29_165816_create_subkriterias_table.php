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
        Schema::create('subkriterias', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_kriteria');
            $table->double('batas_bawah_bobot_subkriteria')->nullable();
            $table->double('batas_atas_bobot_subkriteria')->nullable();
            $table->string('bobot_text_subkriteria')->nullable();
            $table->double('nilai_bobot_subkriteria');
            $table->timestamps();

            $table->foreign('id_kriteria')->references('id')->on('kriterias')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subkriterias');
    }
};
