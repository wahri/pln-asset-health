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
        Schema::create('detail_report', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_asset_id')->references('id')->on('report_asset')->onDelete('cascade')->onUpdate('cascade');
            $table->string('no_sr');
            $table->string('no_wo');
            $table->string('status');
            $table->string('information');
            $table->string('proses');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_report');
    }
};
