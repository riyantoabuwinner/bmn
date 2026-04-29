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
        Schema::create('asset_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Employee Details (Can be auto-filled from User)
            $table->string('employee_name');
            $table->string('employee_id_number')->nullable(); // NIP/NIK
            $table->string('position')->nullable(); // Jabatan
            $table->string('department')->nullable(); // Unit/Divisi

            // Assignment Details
            $table->date('assigned_date');
            $table->enum('status', ['active', 'returned'])->default('active');
            $table->date('return_date')->nullable();

            // Condition
            $table->string('condition_on_assign')->nullable();
            $table->string('condition_on_return')->nullable();

            // Documents & Notes
            $table->string('ba_file')->nullable(); // BAST File path
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_assignments');
    }
};
