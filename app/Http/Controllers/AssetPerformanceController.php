<?php

namespace App\Http\Controllers;

use App\Models\AssetPerformance;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetPerformanceController extends Controller
{
    public function index()
    {
        $performances = AssetPerformance::with('asset')->latest()->get();
        return view('performances.index', compact('performances'));
    }

    public function create()
    {
        return view('performances.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'evaluation_date' => 'required|date',
            'sbsk_target' => 'required|numeric|min:0',
            'actual_usage' => 'required|numeric|min:0',
            'category' => 'required|string',
            'recommendation' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        // Calculate Efficiency Ratio
        if ($data['sbsk_target'] > 0) {
            $data['efficiency_ratio'] = ($data['actual_usage'] / $data['sbsk_target']) * 100;
        }
        else {
            $data['efficiency_ratio'] = 0;
        }

        // Determine Status based on Ratio
        $data['status'] = AssetPerformance::calculateStatus($data['efficiency_ratio']);

        AssetPerformance::create($data);

        return redirect()->route('performances.index')->with('success', 'Evaluasi Kinerja Aset berhasil disimpan.');
    }

    public function show(AssetPerformance $performance)
    {
        $performance->load('asset', 'creator');
        return view('performances.show', compact('performance'));
    }

    public function edit(AssetPerformance $performance)
    {
        return view('performances.edit', compact('performance'));
    }

    public function update(Request $request, AssetPerformance $performance)
    {
        $request->validate([
            'evaluation_date' => 'required|date',
            'sbsk_target' => 'required|numeric|min:0',
            'actual_usage' => 'required|numeric|min:0',
            'category' => 'required|string',
            'recommendation' => 'nullable|string',
        ]);

        $data = $request->all();

        // Recalculate
        if ($data['sbsk_target'] > 0) {
            $data['efficiency_ratio'] = ($data['actual_usage'] / $data['sbsk_target']) * 100;
        }
        else {
            $data['efficiency_ratio'] = 0;
        }

        $data['status'] = AssetPerformance::calculateStatus($data['efficiency_ratio']);

        $performance->update($data);

        return redirect()->route('performances.index')->with('success', 'Evaluasi Kinerja diperbarui.');
    }

    public function destroy(AssetPerformance $performance)
    {
        $performance->delete();
        return redirect()->route('performances.index')->with('success', 'Data evaluasi dihapus.');
    }
}
