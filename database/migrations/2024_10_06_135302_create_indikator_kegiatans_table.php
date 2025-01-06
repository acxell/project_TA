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
        Schema::create('indikator_kegiatans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tor_id');
            $table->longText('indikator');
            $table->timestamps();

            $table->foreign('tor_id')->references('id')->on('tors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indikator_kegiatans');
    }
};
