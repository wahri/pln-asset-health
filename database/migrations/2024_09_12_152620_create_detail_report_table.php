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
            $table->date('tanggal_identifikasi')->nullable();
            $table->string('status_sr')->nullable();
            $table->text('kondisi_asset')->nullable();
            $table->text('action_plan')->nullable();
            $table->string('progress_saat_ini')->nullable();
            $table->year('target_selesai')->nullable();
            $table->integer('realisasi_selesai')->nullable();
            $table->text('issue')->nullable();
            $table->string('keterangan')->nullable();
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
