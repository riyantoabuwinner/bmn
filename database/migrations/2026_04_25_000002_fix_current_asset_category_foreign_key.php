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
        Schema::table('current_assets', function (Blueprint $table) {
            // Drop the old foreign key that points to asset_categories
            $table->dropForeign(['category_id']);
            
            // Add the new foreign key pointing to current_asset_categories
            $table->foreign('category_id')
                  ->references('id')
                  ->on('current_asset_categories')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('current_assets', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            
            $table->foreign('category_id')
                  ->references('id')
                  ->on('asset_categories')
                  ->nullOnDelete();
        });
    }
};
