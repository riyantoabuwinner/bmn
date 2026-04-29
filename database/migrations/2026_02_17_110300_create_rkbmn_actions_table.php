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
        Schema::create('rkbmn_actions', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->string('action_type'); // Sewa, Pinjam Pakai, Jual, Hibah, Tukar Menukar
            $table->text('justification');
            $table->decimal('estimated_revenue', 15, 2)->default(0); // For Sewa/Jual
            $table->string('status')->default('draft');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rkbmn_actions');
    }
};
