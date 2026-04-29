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
        Schema::create('rkbmn_procurements', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->string('name'); // Nama Barang
            $table->string('type'); // Tanah, Gedung, Alat, dll
            $table->integer('quantity');
            $table->string('unit'); // Unit measurement
            $table->decimal('estimated_unit_price', 15, 2);
            $table->decimal('total_price', 15, 2);
            $table->string('priority'); // Tinggi, Sedang, Rendah
            $table->text('justification');
            $table->string('status')->default('draft'); // draft, submitted, approved, rejected
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rkbmn_procurements');
    }
};
