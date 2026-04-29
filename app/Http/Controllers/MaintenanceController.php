<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Asset;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with(['asset'])->latest()->paginate(20);
        return view('maintenances.index', compact('maintenances'));
    }

    public function create(Request $request)
    {
        $assets = Asset::all();
        $selected_asset_id = $request->query('asset_id');
        return view('maintenances.create', compact('assets', 'selected_asset_id'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'maintenance_type' => 'required|in:rutin,perbaikan,kalibrasi',
            'scheduled_date' => 'required|date',
            'description' => 'required|string',
            'estimated_cost' => 'nullable|numeric|min:0',
        ]);

        $validated['status'] = 'dijadwalkan';
        $validated['condition_before'] = Asset::find($validated['asset_id'])->kondisi;

        $maintenance = Maintenance::create($validated);

        // Update asset status
        // Asset::find($validated['asset_id'])->update(['status_pemanfaatan' => 'maintenance']); 
        // Note: keeping status logic simple for now or matching SIMAN fields

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'schedule_maintenance',
            'description' => "Menjadwalkan maintenance untuk aset ID: {$validated['asset_id']}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('maintenances.index')
            ->with('success', 'Jadwal maintenance berhasil dibuat.');
    }

    public function show(Maintenance $maintenance)
    {
        $maintenance->load('asset');
        return view('maintenances.show', compact('maintenance'));
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $validated = $request->validate([
            'status' => 'required|in:dijadwalkan,dalam_proses,selesai,dibatalkan',
            'condition_after' => 'nullable|in:baik,rusak_ringan,rusak_berat',
            'actual_cost' => 'nullable|numeric|min:0',
            'completion_notes' => 'nullable|string',
        ]);

        $maintenance->update($validated);

        // If completed, update asset status back
        if ($validated['status'] == 'selesai') {
            $maintenance->asset->update([
                // 'status_pemanfaatan' => 'Digunakan Sendiri', // Optional mapping
                'kondisi' => $validated['condition_after'] ?? $maintenance->condition_before,
            ]);
        }

        return back()->with('success', 'Status maintenance berhasil diperbarui.');
    }

    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();
        return redirect()->route('maintenances.index')
            ->with('success', 'Data maintenance berhasil dihapus.');
    }

    public function print(Maintenance $maintenance)
    {
        $maintenance->load('asset');
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('maintenances.print', compact('maintenance'));
        return $pdf->stream('Laporan-Maintenance-' . $maintenance->id . '.pdf');
    }
}
