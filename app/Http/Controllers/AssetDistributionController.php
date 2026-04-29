<?php

namespace App\Http\Controllers;

use App\Models\AssetDistribution;
use App\Models\Asset;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AssetDistributionController extends Controller
{
    public function index()
    {
        $distributions = AssetDistribution::with(['asset', 'unit'])->latest()->paginate(20);
        return view('distributions.index', compact('distributions'));
    }

    public function create(Request $request)
    {
        // Available assets (not borrowed)
        $assets = Asset::where('kondisi', '!=', 'Rusak Berat')
            ->where(function ($q) {
            $q->whereNull('status_pemanfaatan')
                ->orWhere('status_pemanfaatan', '!=', 'Dipinjam'); // Simplified check
        })->get();
        $units = \App\Models\Unit::all();
        $selected_asset_id = $request->query('asset_id');
        return view('distributions.create', compact('assets', 'units', 'selected_asset_id'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'unit_id' => 'required|exists:units,id',
            'recipient_name' => 'required|string|max:255',
            'recipient_position' => 'required|string|max:255',
            'distribution_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $asset = Asset::findOrFail($validated['asset_id']);
        $unit = \App\Models\Unit::findOrFail($validated['unit_id']);

        $distribution = AssetDistribution::create($validated);

        // Update asset location/satker info
        $asset->update([
            'kode_satker' => $unit->code, // Assuming Unit has code
            'nama_satker' => $unit->name,
            'status_pemanfaatan' => 'Digunakan oleh ' . $validated['recipient_name']
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'create_distribution',
            'description' => "Mendistribusikan aset: {$asset->nama_barang} ke {$validated['recipient_name']} ({$unit->name})",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('distributions.index')
            ->with('success', 'Distribusi aset berhasil dicatat.');
    }

    public function show(AssetDistribution $distribution)
    {
        $distribution->load(['asset', 'unit']);
        return view('distributions.show', compact('distribution'));
    }

    public function destroy(AssetDistribution $distribution)
    {
        $distribution->delete();
        return redirect()->route('distributions.index')
            ->with('success', 'Data distribusi berhasil dihapus.');
    }

    public function print(AssetDistribution $distribution)
    {
        $distribution->load(['asset', 'unit']);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('distributions.print', compact('distribution'));
        return $pdf->stream('BAST-Distribusi-' . $distribution->id . '.pdf');
    }
}
