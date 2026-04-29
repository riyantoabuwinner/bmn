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
        Schema::table('asset_deletions', function (Blueprint $table) {
            // Check if constraint exists before dropping (safe measure)
            // But usually migration names are standard.
            // We need to drop the FK to assets table first.
            $table->dropForeign(['asset_id']);
            $table->dropColumn('asset_id');

            // Add polymorphic relation
            $table->morphs('asset'); // Adds asset_id and asset_type
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_deletions', function (Blueprint $table) {
            $table->dropMorphs('asset');
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
        });
    }
};
