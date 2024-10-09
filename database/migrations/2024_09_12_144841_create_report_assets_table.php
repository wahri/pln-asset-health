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
        Schema::create('report_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->references('id')->on('assets')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('report_id')->nullable()->references('id')->on('reports')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['normal', 'abnormal', 'fault'])->default('normal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_asset');
    }
};
