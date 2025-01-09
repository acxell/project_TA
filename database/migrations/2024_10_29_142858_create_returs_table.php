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
        Schema::create('returs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('lpj_id');
            $table->string('bukti_retur')->nullable();
            $table->bigInteger('nominal_retur')->nullable();
            $table->bigInteger('total_retur');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->foreign('lpj_id')->references('id')->on('lpjs')->cascadeOnDelete();
            $table->foreign('status_id')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returs');
    }
};
