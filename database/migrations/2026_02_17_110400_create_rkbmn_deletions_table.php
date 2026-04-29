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
        Schema::create('rkbmn_deletions', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->string('deletion_type'); // Rusak Berat, Hilang, Sebab Lain
            $table->text('justification');
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
        Schema::dropIfExists('rkbmn_deletions');
    }
};
