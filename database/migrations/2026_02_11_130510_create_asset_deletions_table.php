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
        Schema::create('asset_deletions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();

            // Jenis Penghapusan
            $table->string('deletion_type'); // Rusak Berat, Hilang, Putusan Pengadilan, dll

            // Dasar Hukum
            $table->string('sk_number');
            $table->date('sk_date');

            // Dokumen Pendukung
            $table->string('document')->nullable();

            $table->text('description')->nullable();

            $table->decimal('value', 15, 2)->default(0); // Nilai saat dihapus

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
        Schema::dropIfExists('asset_deletions');
    }
};
