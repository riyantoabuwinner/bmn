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
        Schema::create('asset_opnames', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->date('opname_date');
            $table->string('physical_condition');
            $table->string('system_condition');
            $table->text('discrepancy_notes')->nullable();
            $table->foreignId('checked_by')->constrained('users');
            $table->enum('status', ['sesuai', 'tidak_sesuai']);
            $table->string('documentation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_opnames');
    }
};
