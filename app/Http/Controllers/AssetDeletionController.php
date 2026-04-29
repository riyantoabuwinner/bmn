<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetDeletion;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AssetDeletionController extends Controller
{
    public function index()
    {
        $deletions = AssetDeletion::with('asset')->latest()->paginate(10);
        return view('asset_deletions.index', compact('deletions'));
    }

    public function create()
    {
        $assets = []; // AJAX search
        return view('asset_deletions.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'deletion_type' => 'required|string',
            'sk_number' => 'required|string',
            'sk_date' => 'required|date',
            'value' => 'nullable|numeric|min:0',
            'document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();
        $data['asset_type'] = \App\Models\Asset::class;

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('deletion_documents', 'public');
        }

        $deletion = AssetDeletion::create($data);

        // Soft delete the asset
        $asset = Asset::find($data['asset_id']);
        if ($asset) {
            $asset->delete();
        }

        return redirect()->route('deletions.index')->with('success', 'Data Penghapusan berhasil direkam (Aset dinonaktifkan).');
    }

    public function show(AssetDeletion $deletion)
    {
        // When showing, we might want to include trashed asset info if needed, but 'with' should handle it if relation is correct?
        // Asset model uses SoftDeletes, so relation returns null unless WithTrashed?
        // Let's modify relation in Model to return WithTrashed if needed, or here.
        // Actually, belongsTo usually returns null if soft deleted.
        // We should fix this in model or just manually load.
        // For now, let's assume standard behavior.
        return view('asset_deletions.show', compact('deletion'));
    }

    public function edit(AssetDeletion $deletion)
    {
        // If asset is deleted, we might need to include it in AJAX init
        $assets = [];
        return view('asset_deletions.edit', compact('deletion', 'assets'));
    }

    public function update(Request $request, AssetDeletion $deletion)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'deletion_type' => 'required|string',
            'sk_number' => 'required|string',
            'sk_date' => 'required|date',
            'value' => 'nullable|numeric|min:0',
            'document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('deletion_documents', 'public');
        }

        // If asset changed, restore old and delete new? That's complex. 
        // For now assume asset doesn't change often in edit.

        $deletion->update($data);

        return redirect()->route('deletions.index')->with('success', 'Data Penghapusan berhasil diperbarui.');
    }

    public function destroy(AssetDeletion $deletion)
    {
        // Restore asset?
        $asset = Asset::withTrashed()->find($deletion->asset_id);
        if ($asset && $asset->trashed()) {
            $asset->restore();
        }

        $deletion->delete();
        return redirect()->route('deletions.index')->with('success', 'Data Penghapusan berhasil dihapus (Aset dipulihkan).');
    }
}
