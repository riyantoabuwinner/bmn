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
        Schema::create('asset_utilizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->string('utilization_type'); // Sewa, Pinjam Pakai, KSP, BGS, BSG
            $table->string('partner_name'); // Pihak Ketiga
            $table->string('contract_number');
            $table->date('contract_date');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('value', 15, 2)->default(0); // Nilai Pemanfaatan (PNBP)
            $table->string('status')->default('active'); // active, expired, extended, etc.
            $table->string('document')->nullable(); // Contract File
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_utilizations');
    }
};
