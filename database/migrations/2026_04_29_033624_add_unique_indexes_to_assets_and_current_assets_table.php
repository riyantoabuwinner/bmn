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
        Schema::table('assets', function (Blueprint $table) {
            $table->unique(['kode_barang', 'nup'], 'assets_unique_key');
        });
        Schema::table('current_assets', function (Blueprint $table) {
            $table->unique(['kode_barang'], 'current_assets_unique_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropUnique('assets_unique_key');
        });
        Schema::table('current_assets', function (Blueprint $table) {
            $table->dropUnique('current_assets_unique_key');
        });
    }
};
