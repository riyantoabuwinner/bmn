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
        Schema::create('asset_performances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->date('evaluation_date');
            $table->decimal('sbsk_target', 10, 2)->default(0); // e.g. Luas Standar
            $table->decimal('actual_usage', 10, 2)->default(0); // e.g. Luas Eisting / Terpakai
            $table->decimal('efficiency_ratio', 8, 2)->default(0); // Percentage
            $table->string('category')->nullable(); // Gedung, Rumah Negara, Alat Angkutan
            $table->string('status')->default('Optimal'); // Optimal, Underutilized, Overutilized
            $table->text('recommendation')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_performances');
    }
};
