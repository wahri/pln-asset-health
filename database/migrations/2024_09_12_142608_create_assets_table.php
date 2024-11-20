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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->references('id')->on('units')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('asset_group_id')->nullable()->references('id')->on('asset_groups')->onDelete('set null');
            $table->string('no_asset')->nullable();
            $table->string('name');
            $table->enum('status', ['normal', 'abnormal', 'fault'])->default('normal');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset');
    }
};
