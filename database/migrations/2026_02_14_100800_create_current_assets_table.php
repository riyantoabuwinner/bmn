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
        Schema::create('current_assets', function (Blueprint $table) {
            $table->id();

            // Identity
            $table->string('kode_barang')->index();
            $table->string('nama_barang');
            $table->string('kategori')->nullable(); // ATK, Konsumsi, dll

            // Stock Management
            $table->integer('stok_awal')->default(0);
            $table->integer('stok_masuk')->default(0);
            $table->integer('stok_keluar')->default(0);
            $table->integer('stok_tersedia')->default(0); // Calculated field
            $table->integer('stok_minimum')->default(0); // Alert threshold

            // Financial
            $table->decimal('harga_satuan', 15, 2)->default(0);
            $table->decimal('nilai_total', 15, 2)->default(0); // stok_tersedia * harga_satuan

            // Acquisition & Location
            $table->date('tanggal_perolehan')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->string('lokasi_penyimpanan')->nullable();

            // Details
            $table->string('satuan')->default('Unit'); // Pcs, Box, Rim, dll
            $table->text('spesifikasi')->nullable();
            $table->text('keterangan')->nullable();

            // Relationships
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('asset_categories')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_assets');
    }
};
