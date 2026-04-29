<?php

namespace App\Http\Controllers;

use App\Models\AssetPsp;
use Illuminate\Http\Request;

class AssetPspController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $psp_documents = AssetPsp::with('asset')->latest()->paginate(10);
        return view('psp.index', compact('psp_documents'));
    }

    public function create()
    {
        $assets = [];
        return view('psp.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'sk_number' => 'required|string|max:255',
            'sk_date' => 'required|date',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('psp_documents', 'public');
        }

        AssetPsp::create($data);

        return redirect()->route('psp.index')->with('success', 'Dokumen PSP berhasil direkam.');
    }

    public function show(AssetPsp $psp)
    {
        return view('psp.show', compact('psp'));
    }

    public function edit(AssetPsp $psp)
    {
        $assets = [];
        return view('psp.edit', compact('psp', 'assets'));
    }

    public function update(Request $request, AssetPsp $psp)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'sk_number' => 'required|string|max:255',
            'sk_date' => 'required|date',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('psp_documents', 'public');
        }

        $psp->update($data);

        return redirect()->route('psp.index')->with('success', 'Dokumen PSP berhasil diperbarui.');
    }

    public function destroy(AssetPsp $psp)
    {
        $psp->delete();
        return redirect()->route('psp.index')->with('success', 'Dokumen PSP berhasil dihapus.');
    }
}
