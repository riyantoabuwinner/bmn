<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetUtilization;
use Illuminate\Http\Request;

class AssetUtilizationController extends Controller
{
    public function index()
    {
        $utilizations = AssetUtilization::with('asset')->latest()->paginate(10);
        return view('utilizations.index', compact('utilizations'));
    }

    public function create()
    {
        $assets = [];
        return view('utilizations.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'utilization_type' => 'required|string',
            'partner_name' => 'required|string',
            'contract_number' => 'required|string',
            'contract_date' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'value' => 'required|numeric|min:0',
            'document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('utilization_documents', 'public');
        }

        AssetUtilization::create($data);

        return redirect()->route('utilizations.index')->with('success', 'Data Pemanfaatan berhasil direkam.');
    }

    public function show(AssetUtilization $utilization)
    {
        return view('utilizations.show', compact('utilization'));
    }

    public function edit(AssetUtilization $utilization)
    {
        $assets = [];
        return view('utilizations.edit', compact('utilization', 'assets'));
    }

    public function update(Request $request, AssetUtilization $utilization)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'utilization_type' => 'required|string',
            'partner_name' => 'required|string',
            'contract_number' => 'required|string',
            'contract_date' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'value' => 'required|numeric|min:0',
            'document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('utilization_documents', 'public');
        }

        $utilization->update($data);

        return redirect()->route('utilizations.index')->with('success', 'Data Pemanfaatan berhasil diperbarui.');
    }

    public function destroy(AssetUtilization $utilization)
    {
        $utilization->delete();
        return redirect()->route('utilizations.index')->with('success', 'Data Pemanfaatan berhasil dihapus.');
    }
}
