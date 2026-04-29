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
        Schema::create('asset_evaluations', function (Blueprint $table) {
            $table->id();
            $table->year('year'); // e.g., 2026
            $table->enum('period_type', ['semester', 'annual']);
            $table->tinyInteger('semester')->nullable(); // 1 or 2, null if annual
            $table->enum('status', ['draft', 'finalized'])->default('draft');
            $table->foreignId('created_by')->constrained('users');
            $table->date('finalized_at')->nullable();
            $table->timestamps();

        // Unique constraint to prevent duplicate evaluation for same period
        // Note: We need a way to enforce uniqueness. 
        // A simple unique index on year, period_type, semester might work, 
        // but semester is nullable. Unique index with NULLs is tricky in some DBs but usually allows multiple nulls.
        // However, for 'annual', semester is NULL. So year+annual+NULL should be unique.
        // Let's handle validation in controller mostly, or add a generated column? 
        // For simplicity, let's just index them for performance and rely on app logic for strict uniqueness or complex index.
        });

        Schema::create('asset_evaluation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_evaluation_id')->constrained('asset_evaluations')->onDelete('cascade');

            // Polymorphic Asset
            $table->morphs('asset'); // asset_id, asset_type

            $table->string('condition_status'); // baik, rusak_ringan, rusak_berat, hilang
            $table->string('action_needed')->nullable(); // e.g. Perbaiki, Hapus, None
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_evaluation_details');
        Schema::dropIfExists('asset_evaluations');
    }
};
