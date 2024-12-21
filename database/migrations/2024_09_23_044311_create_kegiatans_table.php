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
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tor_id');
            $table->uuid('rab_id')->nullable();
            $table->string('status');
            $table->uuid('user_id');
            $table->uuid('unit_id');
            $table->uuid('satuan_id');
            $table->string('jenis');
            $table->uuid('tahunan_id');
            $table->timestamps();

            $table->foreign('tor_id')->references('id')->on('tors')->onDelete('cascade');
            $table->foreign('rab_id')->references('id')->on('rabs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('penggunas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};
