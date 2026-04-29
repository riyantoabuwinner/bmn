<?php

namespace App\Http\Controllers;

use App\Models\AssetInsurance;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetInsuranceController extends Controller
{
    public function index()
    {
        $insurances = AssetInsurance::with('asset')->latest()->get();
        return view('insurances.index', compact('insurances'));
    }

    public function create()
    {
        return view('insurances.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'policy_number' => 'nullable|string',
            'insurance_company' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'coverage_amount' => 'nullable|numeric',
            'premium_amount' => 'nullable|numeric',
            'status' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('insurances', 'public');
        }

        AssetInsurance::create($data);

        return redirect()->route('insurances.index')->with('success', 'Pendaftaran asuransi berhasil disimpan.');
    }

    public function show(AssetInsurance $insurance)
    {
        $insurance->load('asset', 'creator');
        return view('insurances.show', compact('insurance'));
    }

    public function edit(AssetInsurance $insurance)
    {
        return view('insurances.edit', compact('insurance'));
    }

    public function update(Request $request, AssetInsurance $insurance)
    {
        $request->validate([
            'policy_number' => 'nullable|string',
            'insurance_company' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'coverage_amount' => 'nullable|numeric',
            'premium_amount' => 'nullable|numeric',
            'status' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('document')) {
            if ($insurance->document) {
                Storage::disk('public')->delete($insurance->document);
            }
            $data['document'] = $request->file('document')->store('insurances', 'public');
        }

        $insurance->update($data);

        return redirect()->route('insurances.index')->with('success', 'Data asuransi berhasil diperbarui.');
    }

    public function destroy(AssetInsurance $insurance)
    {
        if ($insurance->document) {
            Storage::disk('public')->delete($insurance->document);
        }
        $insurance->delete();

        return redirect()->route('insurances.index')->with('success', 'Data asuransi berhasil dihapus.');
    }
}
