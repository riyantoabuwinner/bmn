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
        Schema::create('asset_wasdal_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();

            $table->integer('period_year');
            $table->string('report_type'); // Semester I, Semester II, Tahunan

            $table->string('condition_status'); // Baik, Rusak Ringan, Rusak Berat
            $table->string('usage_status'); // Digunakan, Idle/Tidak Digunakan

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
        Schema::dropIfExists('asset_wasdal_reports');
    }
};
