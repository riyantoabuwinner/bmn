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
        Schema::create('rkbmn_maintenances', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->text('condition_summary'); // Ringkasan Kondisi
            $table->string('maintenance_type'); // Ringan, Berat, Renovasi
            $table->decimal('estimated_cost', 15, 2);
            $table->text('justification');
            $table->string('status')->default('draft');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rkbmn_maintenances');
    }
};
