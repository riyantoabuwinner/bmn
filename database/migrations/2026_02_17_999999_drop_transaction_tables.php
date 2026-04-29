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
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('asset_utilizations');
        Schema::dropIfExists('asset_evaluation_details');
        Schema::dropIfExists('asset_evaluations');
        Schema::dropIfExists('asset_assignments');
        Schema::dropIfExists('asset_deletions');
        Schema::dropIfExists('asset_opnames');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('maintenances');
        Schema::dropIfExists('borrowings');
        Schema::dropIfExists('asset_distributions');

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    // No reverse, this is a destructive cleanup
    }
};
