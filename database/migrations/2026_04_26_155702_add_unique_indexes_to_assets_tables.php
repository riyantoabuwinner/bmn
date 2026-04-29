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
        // For Assets
        Schema::table('assets', function (Blueprint $table) {
            // Drop existing non-unique index if it exists (from previous migration)
            try {
                $table->dropIndex('idx_assets_lookup');
            } catch (\Exception $e) {
                // Ignore if not exists
            }
            
            // Add UNIQUE index for proper upsert performance
            $table->unique(['kode_barang', 'nup'], 'assets_kode_nup_unique');
        });

        // For Current Assets
        Schema::table('current_assets', function (Blueprint $table) {
            // Add UNIQUE index if not exists
            $table->unique(['kode_barang'], 'current_assets_kode_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropUnique('assets_kode_nup_unique');
            // Restore non-unique index
            $table->index(['kode_barang', 'nup'], 'idx_assets_lookup');
        });

        Schema::table('current_assets', function (Blueprint $table) {
            $table->dropUnique('current_assets_kode_unique');
        });
    }
};
