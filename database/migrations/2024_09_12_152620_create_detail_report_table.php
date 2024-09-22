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
            $table->foreignId('report_asset_id')->references('id')->on('report_assets')->onDelete('cascade')->onUpdate('cascade');
            $table->string('no_sr')->nullable();
            $table->string('no_wo')->nullable();
            $table->string('status')->nullable();
            $table->string('issue')->nullable();
            $table->string('information')->nullable();
            $table->string('proses')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('deskripsi_asset')->nullable();
            $table->string('kondisi_asset')->nullable();
            $table->string('action_plan')->nullable();
            $table->date('target_selesai')->nullable();
            $table->integer('persentase_progress')->nullable();
            $table->string('realisasi_selesai')->nullable();
            $table->string('tanggal_identifikasi')->nullable();
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
