<?php

namespace App\Http\Controllers;

use App\Models\AssetTransfer;
use Illuminate\Http\Request;

class AssetTransferController extends Controller
{
    public function index()
    {
        $transfers = AssetTransfer::with('asset')->latest()->paginate(10);
        return view('transfers.index', compact('transfers'));
    }

    public function create()
    {
        $assets = []; // AJAX search
        return view('transfers.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'transfer_type' => 'required|string',
            'recipient_name' => 'required|string',
            'sk_number' => 'required|string',
            'sk_date' => 'required|date',
            'value' => 'nullable|numeric|min:0',
            'document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('transfer_documents', 'public');
        }

        AssetTransfer::create($data);

        return redirect()->route('transfers.index')->with('success', 'Data Pemindahtanganan berhasil direkam.');
    }

    public function show(AssetTransfer $transfer)
    {
        return view('transfers.show', compact('transfer'));
    }

    public function edit(AssetTransfer $transfer)
    {
        $assets = []; // AJAX search
        return view('transfers.edit', compact('transfer', 'assets'));
    }

    public function update(Request $request, AssetTransfer $transfer)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'transfer_type' => 'required|string',
            'recipient_name' => 'required|string',
            'sk_number' => 'required|string',
            'sk_date' => 'required|date',
            'value' => 'nullable|numeric|min:0',
            'document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('transfer_documents', 'public');
        }

        $transfer->update($data);

        return redirect()->route('transfers.index')->with('success', 'Data Pemindahtanganan berhasil diperbarui.');
    }

    public function destroy(AssetTransfer $transfer)
    {
        $transfer->delete();
        return redirect()->route('transfers.index')->with('success', 'Data Pemindahtanganan berhasil dihapus.');
    }
}
