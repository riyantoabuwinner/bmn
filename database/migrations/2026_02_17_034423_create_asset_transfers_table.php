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
        Schema::create('asset_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();

            // Jenis Pemindahtanganan
            $table->string('transfer_type'); // Penjualan, Hibah, Tukar Menukar, PMP

            // Pihak Penerima
            $table->string('recipient_name');

            // Dasar Hukum
            $table->string('sk_number');
            $table->date('sk_date');

            // Nilai (jika ada, misal Penjualan)
            $table->decimal('value', 15, 2)->default(0);

            // Dokumen Pendukung
            $table->string('document')->nullable();

            $table->text('description')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_transfers');
    }
};
