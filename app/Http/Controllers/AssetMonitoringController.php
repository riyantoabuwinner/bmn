<?php

namespace App\Http\Controllers;

use App\Models\AssetMonitoring;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetMonitoringController extends Controller
{
    public function index()
    {
        $monitorings = AssetMonitoring::with('asset')->latest()->paginate(10);
        return view('wasdal.monitorings.index', compact('monitorings'));
    }

    public function create()
    {
        $assets = []; // AJAX search
        return view('wasdal.monitorings.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'inspection_date' => 'required|date',
            'inspector_name' => 'required|string',
            'usage_conformity' => 'required|string',
            'is_idle' => 'required|boolean',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        AssetMonitoring::create($data);

        return redirect()->route('wasdal-monitorings.index')->with('success', 'Hasil Monitoring berhasil dicatat.');
    }

    public function show(AssetMonitoring $wasdal_monitoring)
    {
        return view('wasdal.monitorings.show', ['monitoring' => $wasdal_monitoring]);
    }

    public function edit(AssetMonitoring $wasdal_monitoring)
    {
        $assets = [];
        return view('wasdal.monitorings.edit', ['monitoring' => $wasdal_monitoring, 'assets' => $assets]);
    }

    public function update(Request $request, AssetMonitoring $wasdal_monitoring)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'inspection_date' => 'required|date',
            'inspector_name' => 'required|string',
            'usage_conformity' => 'required|string',
            'is_idle' => 'required|boolean',
        ]);

        $wasdal_monitoring->update($request->all());

        return redirect()->route('wasdal-monitorings.index')->with('success', 'Data Monitoring berhasil diperbarui.');
    }

    public function destroy(AssetMonitoring $wasdal_monitoring)
    {
        $wasdal_monitoring->delete();
        return redirect()->route('wasdal-monitorings.index')->with('success', 'Data Monitoring berhasil dihapus.');
    }
}
