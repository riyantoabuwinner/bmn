<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\AssetLocationController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\CurrentAssetController;
use App\Http\Controllers\AssetDistributionController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\AssetOpnameController;
use App\Http\Controllers\AssetDeletionController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SystemUpdateController;
use App\Http\Controllers\UserGuideController;
use App\Http\Controllers\AssetPspController;
use App\Http\Controllers\AssetUtilizationController;
use App\Http\Controllers\AssetTransferController;
use App\Http\Controllers\RkbmnProcurementController;
use App\Http\Controllers\RkbmnMaintenanceController;
use App\Http\Controllers\RkbmnActionController;
use App\Http\Controllers\RkbmnDeletionController;
use App\Http\Controllers\AssetAssignmentController;
use App\Http\Controllers\AssetEvaluationController;
use App\Http\Controllers\AssetWasdalReportController;
use App\Http\Controllers\AssetMonitoringController;
use App\Http\Controllers\AssetInsuranceController;
use App\Http\Controllers\AssetPerformanceController;
use Illuminate\Support\Facades\Route;

Route::get('/refresh-captcha', function() {
    return response()->json(['captcha' => captcha_img('flat')]);
});

Route::get('/', [App\Http\Controllers\LandingController::class , 'index'])->name('landing');

// Pending Approval Page
Route::get('/pending-approval', function () {
    return view('auth.pending-approval');
})->middleware(['auth', 'verified'])->name('pending-approval');

Route::middleware(['auth', 'verified'])->group(function () {
    // Role Request Routes
    Route::get('/role-request', [App\Http\Controllers\RoleRequestController::class , 'create'])->name('role-requests.create');
    Route::post('/role-request', [App\Http\Controllers\RoleRequestController::class , 'store'])->name('role-requests.store');
});

Route::get('/dashboard', [DashboardController::class , 'index'])
    ->middleware(['auth', 'verified', \App\Http\Middleware\EnsureUserIsApproved::class])
    ->name('dashboard');

Route::middleware(['auth', 'verified', \App\Http\Middleware\EnsureUserIsApproved::class])->group(function () {
    // Routes for regular users (stakeholder/umum) - placeholder
    Route::middleware('role:user|stakeholder|umum')->group(function () {
        // No transactions for now
    });

    // Routes for admin/operator/staff - asset management
    Route::middleware('role:superadmin|admin|admin_rektorat|operator_fakultas|staff')->group(function () {
        // Master Data
        Route::resource('units', UnitController::class);
        Route::resource('categories', AssetCategoryController::class);
        Route::resource('current-asset-categories', App\Http\Controllers\CurrentAssetCategoryController::class);
        Route::resource('locations', AssetLocationController::class);

        // Import/Export
        Route::get('assets/import/status/{task}', [App\Http\Controllers\AssetImportController::class, 'status'])->name('assets.import.status');

        Route::post('assets/import', [AssetController::class , 'import'])->name('assets.import');
        Route::get('assets/export', [AssetController::class , 'export'])->name('assets.export');
        Route::get('assets/export/progress/{jobId}', [AssetController::class , 'checkExportProgress'])->name('assets.export.progress');
        Route::get('assets/export/download/{jobId}', [AssetController::class , 'downloadExport'])->name('assets.export.download');
        Route::get('assets/template', [AssetController::class , 'downloadTemplate'])->name('assets.template');
        Route::get('assets/import/progress', [AssetController::class , 'checkImportProgress'])->name('assets.import.progress');
        Route::get('assets/import/clear-session', [AssetController::class , 'clearImportSession'])->name('assets.import.clear-session');
        Route::post('assets/bulk-delete', [AssetController::class , 'bulkDelete'])->name('assets.bulk-delete');
        Route::get('assets/search', [AssetController::class , 'search'])->name('assets.search');

        // Asset Management
        Route::resource('assets', AssetController::class);
        Route::post('assets/{asset}/update-inventory', [AssetController::class , 'updateInventory'])->name('assets.update-inventory');

        // Current Assets Routes
        Route::post('current-assets/import', [CurrentAssetController::class , 'import'])->name('current-assets.import');
        Route::get('current-assets/import/progress', [CurrentAssetController::class , 'checkImportProgress'])->name('current-assets.import.progress');
        Route::get('current-assets/import/clear-session', [CurrentAssetController::class , 'clearImportSession'])->name('current-assets.import.clear-session');
        Route::get('current-assets/export', [CurrentAssetController::class , 'export'])->name('current-assets.export');
        Route::get('current-assets/template', [CurrentAssetController::class , 'downloadTemplate'])->name('current-assets.template');
        Route::post('current-assets/bulk-delete', [CurrentAssetController::class , 'bulkDelete'])->name('current-assets.bulk-delete');
        Route::post('current-assets/{id}/adjust-stock', [CurrentAssetController::class , 'adjustStock'])->name('current-assets.adjust-stock');
        Route::resource('current-assets', CurrentAssetController::class);

        // Current Asset Transactions (SAKTI)
        Route::resource('current-asset-transactions', App\Http\Controllers\CurrentAssetTransactionController::class);
        Route::post('current-asset-transactions/{transaction}/action', [App\Http\Controllers\CurrentAssetTransactionController::class , 'action'])->name('current-asset-transactions.action');

        // Penetapan Status Penggunaan (PSP)
        Route::resource('psp', AssetPspController::class);

        // Pemanfaatan (Sewa, Pinjam Pakai, dll)
        Route::resource('utilizations', AssetUtilizationController::class);
        Route::resource('transfers', AssetTransferController::class);
        Route::resource('deletions', AssetDeletionController::class);

        // ============================================================
        // DISTRIBUSI ASET
        // ============================================================
        Route::resource('distributions', AssetDistributionController::class);
        Route::get('distributions/{distribution}/print', [AssetDistributionController::class, 'print'])->name('distributions.print');

        // ============================================================
        // PEMINJAMAN ASET
        // ============================================================
        Route::resource('borrowings', BorrowingController::class);
        Route::post('borrowings/{borrowing}/approve', [BorrowingController::class, 'approve'])->name('borrowings.approve');
        Route::post('borrowings/{borrowing}/reject', [BorrowingController::class, 'reject'])->name('borrowings.reject');
        Route::post('borrowings/{borrowing}/return', [BorrowingController::class, 'returnAsset'])->name('borrowings.return');

        // ============================================================
        // PEMEGANG ASET (ASSIGNMENT / BAST)
        // ============================================================
        Route::resource('assignments', AssetAssignmentController::class);
        Route::get('assignments/{assignment}/return', [AssetAssignmentController::class, 'returnAsset'])->name('assignments.return');
        Route::post('assignments/{assignment}/process-return', [AssetAssignmentController::class, 'processReturn'])->name('assignments.process-return');
        Route::get('assignments/{assignment}/print', [AssetAssignmentController::class, 'print'])->name('assignments.print');

        // ============================================================
        // EVALUASI ASET BERKALA
        // ============================================================
        Route::resource('evaluations', AssetEvaluationController::class);
        Route::get('evaluations/{evaluation}/print', [AssetEvaluationController::class, 'print'])->name('evaluations.print');

        // ============================================================
        // MAINTENANCE / PEMELIHARAAN ASET
        // ============================================================
        Route::resource('maintenances', MaintenanceController::class);
        Route::get('maintenances/{maintenance}/print', [MaintenanceController::class, 'print'])->name('maintenances.print');

        // Wasdal (Pengawasan dan Pengendalian)
        Route::resource('wasdal-reports', AssetWasdalReportController::class);
        Route::resource('wasdal-monitorings', AssetMonitoringController::class);
        Route::resource('insurances', AssetInsuranceController::class);
        Route::resource('performances', AssetPerformanceController::class);

        // Perencanaan (RKBMN)
        Route::group(['prefix' => 'rkbmn', 'as' => 'rkbmn.'], function () {
            Route::resource('procurements', RkbmnProcurementController::class);
            Route::resource('maintenances', RkbmnMaintenanceController::class);
            Route::resource('actions', RkbmnActionController::class);
            Route::resource('deletions', RkbmnDeletionController::class);
        });

        // QR Scanner
        Route::get('/scan-aset', [AssetController::class , 'scanner'])->name('assets.scanner');
        Route::get('/api/aset/scan/{qr_code}', [AssetController::class , 'scanQr'])->name('assets.scan');
        // Quick Actions
        Route::patch('/assets/{asset}/update-location', [AssetController::class , 'updateLocation'])->name('assets.update-location');
    });

    // Routes for admin/operator - logs
    Route::middleware('role:superadmin|admin|admin_rektorat|operator_fakultas')->group(function () {
        // System Update
        Route::get('system/update', [SystemUpdateController::class, 'index'])->name('system.update.index');
        Route::post('system/update/check', [SystemUpdateController::class, 'check'])->name('system.update.check');
        Route::post('system/update/apply', [SystemUpdateController::class, 'apply'])->name('system.update.apply');

        // User Guide
        Route::get('guide', [UserGuideController::class, 'index'])->name('guide.index');

        // Activity Logs
        Route::get('logs', [ActivityLogController::class , 'index'])->name('logs.index');

        // Role Requests Management
        Route::get('role-requests', [App\Http\Controllers\RoleRequestController::class , 'index'])->name('role-requests.index');
        Route::post('role-requests/{roleRequest}/approve', [App\Http\Controllers\RoleRequestController::class , 'approve'])->name('role-requests.approve');
        Route::post('role-requests/{roleRequest}/reject', [App\Http\Controllers\RoleRequestController::class , 'reject'])->name('role-requests.reject');
    });

    // Routes for admin only - user management
    Route::middleware('role:superadmin|admin')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Impersonate
    Route::impersonate();
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class , 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class , 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class , 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
