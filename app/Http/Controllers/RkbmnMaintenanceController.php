<?php

namespace App\Http\Controllers;

use App\Models\RkbmnMaintenance;
use App\Models\Asset;
use Illuminate\Http\Request;

class RkbmnMaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = RkbmnMaintenance::with('asset')->latest()->paginate(10);
        return view('rkbmn.maintenances.index', compact('maintenances'));
    }

    public function create()
    {
        // $assets = Asset::all(); // Too heavy, utilizing AJAX search
        $assets = []; // Initial empty list
        return view('rkbmn.maintenances.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2025|max:2030',
            'asset_id' => 'required|exists:assets,id',
            'condition_summary' => 'required|string',
            'maintenance_type' => 'required|string', // Ringan, Berat
            'estimated_cost' => 'required|numeric|min:0',
            'justification' => 'required|string',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();
        $data['status'] = 'draft';

        RkbmnMaintenance::create($data);

        return redirect()->route('rkbmn.maintenances.index')->with('success', 'Usulan Pemeliharaan berhasil direkam.');
    }

    public function show(RkbmnMaintenance $maintenance)
    {
        return view('rkbmn.maintenances.show', compact('maintenance'));
    }

    public function edit(RkbmnMaintenance $maintenance)
    {
        // $assets = Asset::all();
        $assets = [];
        return view('rkbmn.maintenances.edit', compact('maintenance', 'assets'));
    }

    public function update(Request $request, RkbmnMaintenance $maintenance)
    {
        $request->validate([
            'year' => 'required|integer|min:2025|max:2030',
            'asset_id' => 'required|exists:assets,id',
            'condition_summary' => 'required|string',
            'maintenance_type' => 'required|string',
            'estimated_cost' => 'required|numeric|min:0',
            'justification' => 'required|string',
        ]);

        $maintenance->update($request->all());

        return redirect()->route('rkbmn.maintenances.index')->with('success', 'Usulan Pemeliharaan berhasil diperbarui.');
    }

    public function destroy(RkbmnMaintenance $maintenance)
    {
        $maintenance->delete();
        return redirect()->route('rkbmn.maintenances.index')->with('success', 'Usulan Pemeliharaan berhasil dihapus.');
    }
}
