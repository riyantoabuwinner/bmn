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
        Schema::create('aset_lainnya', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code')->unique();
            $table->string('name');
            $table->foreignId('category_id')->constrained('asset_categories');
            $table->foreignId('unit_id')->constrained('units');
            $table->foreignId('location_id')->constrained('asset_locations');

            // Asset type and description
            $table->string('asset_type')->nullable(); // License, Subscription, Digital, etc.
            $table->text('description')->nullable();

            // Financial fields
            $table->decimal('purchase_value', 15, 2)->default(0);
            $table->decimal('current_value', 15, 2)->default(0);

            // Tracking fields
            $table->date('purchase_date');
            $table->date('start_date')->nullable(); // for subscriptions/licenses
            $table->date('end_date')->nullable(); // for subscriptions/licenses

            // Flexible custom fields (JSON)
            $table->json('custom_fields')->nullable();

            // Status
            $table->string('status')->default('active'); // active, inactive, expired, cancelled

            // Other
            $table->string('qr_code')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset_lainnya');
    }
};
