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
        Schema::create('units', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama')->unique();
            $table->text('description');
            $table->boolean('status');
            $table->string('nomor_rekening');
            $table->uuid('satuan_id');
            $table->timestamps();

            $table->foreign('satuan_id')->references('id')->on('satuan_kerjas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
