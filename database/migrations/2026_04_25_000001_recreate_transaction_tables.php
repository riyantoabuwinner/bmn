<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Re-create tables that were dropped by the 2026_02_17_999999_drop_transaction_tables migration.
     * Schemas are updated to match the current controller implementations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // 1. Borrowings - matches BorrowingController
        if (!Schema::hasTable('borrowings')) {
            Schema::create('borrowings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
                $table->string('borrower_name');
                $table->string('borrower_phone', 20);
                $table->string('borrower_email')->nullable();
                $table->date('borrow_date');
                $table->date('return_date');
                $table->text('purpose');
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('approved_at')->nullable();
                $table->timestamp('returned_at')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 2. Asset Distributions - matches AssetDistributionController
        if (!Schema::hasTable('asset_distributions')) {
            Schema::create('asset_distributions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
                $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
                $table->string('recipient_name');
                $table->string('recipient_position');
                $table->date('distribution_date');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 3. Maintenances - matches MaintenanceController
        if (!Schema::hasTable('maintenances')) {
            Schema::create('maintenances', function (Blueprint $table) {
                $table->id();
                $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
                $table->enum('maintenance_type', ['rutin', 'perbaikan', 'kalibrasi']);
                $table->date('scheduled_date');
                $table->string('condition_before')->nullable();
                $table->string('condition_after')->nullable();
                $table->text('description')->nullable();
                $table->decimal('estimated_cost', 15, 2)->default(0);
                $table->decimal('actual_cost', 15, 2)->nullable();
                $table->enum('status', ['dijadwalkan', 'dalam_proses', 'selesai', 'dibatalkan'])->default('dijadwalkan');
                $table->text('completion_notes')->nullable();
                $table->timestamps();
            });
        }

        // 4. Asset Assignments (BAST) - matches AssetAssignmentController
        if (!Schema::hasTable('asset_assignments')) {
            Schema::create('asset_assignments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('employee_name');
                $table->string('employee_id_number', 50)->nullable();
                $table->string('position', 100)->nullable();
                $table->string('department', 100)->nullable();
                $table->date('assigned_date');
                $table->enum('status', ['active', 'returned'])->default('active');
                $table->date('return_date')->nullable();
                $table->string('condition_on_assign')->nullable();
                $table->string('condition_on_return')->nullable();
                $table->string('ba_file')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 5. Asset Evaluations - matches AssetEvaluationController
        if (!Schema::hasTable('asset_evaluations')) {
            Schema::create('asset_evaluations', function (Blueprint $table) {
                $table->id();
                $table->year('year');
                $table->enum('period_type', ['semester', 'annual']);
                $table->tinyInteger('semester')->nullable();
                $table->enum('status', ['draft', 'finalized'])->default('draft');
                $table->foreignId('created_by')->constrained('users');
                $table->timestamp('finalized_at')->nullable();
                $table->timestamps();
            });
        }

        // 6. Asset Evaluation Details
        if (!Schema::hasTable('asset_evaluation_details')) {
            Schema::create('asset_evaluation_details', function (Blueprint $table) {
                $table->id();
                $table->foreignId('asset_evaluation_id')->constrained('asset_evaluations')->onDelete('cascade');
                $table->morphs('asset');
                $table->string('condition_status');
                $table->string('action_needed')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 7. Asset Deletions (polymorphic) - matches AssetDeletionController
        if (!Schema::hasTable('asset_deletions')) {
            Schema::create('asset_deletions', function (Blueprint $table) {
                $table->id();
                $table->morphs('asset'); // asset_id + asset_type (polymorphic)
                $table->string('deletion_type');
                $table->string('sk_number');
                $table->date('sk_date');
                $table->string('document')->nullable();
                $table->text('description')->nullable();
                $table->decimal('value', 15, 2)->default(0);
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // 8. Asset Opnames
        if (!Schema::hasTable('asset_opnames')) {
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

        // 9. Payments
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('borrowing_id')->constrained('borrowings')->onDelete('cascade');
                $table->decimal('amount', 15, 2);
                $table->string('payment_method')->default('transfer');
                $table->string('proof_of_payment')->nullable();
                $table->timestamp('paid_at')->nullable();
                $table->foreignId('verified_by')->nullable()->constrained('users');
                $table->timestamps();
            });
        }

        // 10. Asset Utilizations - matches AssetUtilizationController
        if (!Schema::hasTable('asset_utilizations')) {
            Schema::create('asset_utilizations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
                $table->string('utilization_type');
                $table->string('partner_name');
                $table->string('contract_number');
                $table->date('contract_date');
                $table->date('start_date');
                $table->date('end_date');
                $table->decimal('value', 15, 2)->default(0);
                $table->string('status')->default('active');
                $table->string('document')->nullable();
                $table->text('description')->nullable();
                $table->foreignId('created_by')->constrained('users');
                $table->timestamps();
            });
        }

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('payments');
        Schema::dropIfExists('asset_evaluation_details');
        Schema::dropIfExists('asset_evaluations');
        Schema::dropIfExists('asset_utilizations');
        Schema::dropIfExists('asset_opnames');
        Schema::dropIfExists('asset_deletions');
        Schema::dropIfExists('asset_assignments');
        Schema::dropIfExists('maintenances');
        Schema::dropIfExists('borrowings');
        Schema::dropIfExists('asset_distributions');
        Schema::enableForeignKeyConstraints();
    }
};
