<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\CurrentAsset;
use App\Models\AssetPsp;
use App\Models\AssetInsurance;
use App\Models\AssetPerformance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_fixed_assets = Asset::count();

        $stats = [
            // Fixed Assets (Aset Tetap) - Basic
            'total_assets' => $total_fixed_assets,
            'available_assets' => Asset::where('status_pemanfaatan', 'Digunakan')->count(),
            'maintenance_assets' => Asset::where('status_pemanfaatan', 'Dalam Pemeliharaan')->count(),
            'total_value' => Asset::sum('nilai_perolehan'),

            // Fixed Assets - Conditions
            'condition_baik' => Asset::where('kondisi', 'Baik')->count(),
            'condition_rr' => Asset::where('kondisi', 'Rusak Ringan')->count(),
            'condition_rb' => Asset::where('kondisi', 'Rusak Berat')->count(),

            // Management Status (Coverage)
            'psp_count' => AssetPsp::distinct('asset_id')->count(),
            'insurance_count' => AssetInsurance::where('status', 'Aktif')->distinct('asset_id')->count(),
            'performance_count' => AssetPerformance::distinct('asset_id')->count(),

            // Current Assets (Aset Lancar / Persediaan)
            'total_current_assets' => CurrentAsset::sum('stok_tersedia'),
            'total_current_value' => CurrentAsset::sum('nilai_total'),
            'low_stock_count' => CurrentAsset::whereRaw('stok_tersedia <= stok_minimum')->count(),
            'total_current_types' => CurrentAsset::count(),
        ];

        // Calculate Percentages for progress bars
        $stats['psp_percentage'] = $total_fixed_assets > 0 ? ($stats['psp_count'] / $total_fixed_assets) * 100 : 0;
        $stats['insurance_percentage'] = $total_fixed_assets > 0 ? ($stats['insurance_count'] / $total_fixed_assets) * 100 : 0;
        $stats['performance_percentage'] = $total_fixed_assets > 0 ? ($stats['performance_count'] / $total_fixed_assets) * 100 : 0;

        $recent_assets = Asset::latest()->take(5)->get();
        $recent_current_assets = CurrentAsset::latest()->take(5)->get();
        $recent_borrowings = []; // Placeholder

        return view('dashboard', compact('stats', 'recent_assets', 'recent_current_assets', 'recent_borrowings'));
    }
}
