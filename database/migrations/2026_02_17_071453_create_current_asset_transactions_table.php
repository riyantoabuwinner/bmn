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
        Schema::create('current_asset_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('current_asset_id')->constrained('current_assets')->onDelete('cascade');

            // Transaction Details
            $table->string('transaction_type'); // purchase, transfer_in, grant_in, production, usage, transfer_out, grant_out, disposal, correction, opname
            $table->string('reference_number')->nullable(); // No. Dokumen / BAST
            $table->date('transaction_date');

            // Values
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->decimal('total_price', 15, 2)->default(0);

            // Meta
            $table->text('description')->nullable();
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft');
            $table->string('proof_document')->nullable(); // Path to PDF/Image

            // Audit
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->dateTime('approved_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_asset_transactions');
    }
};
