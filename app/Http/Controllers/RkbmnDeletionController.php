<?php

namespace App\Http\Controllers;

use App\Models\RkbmnDeletion;
use App\Models\Asset;
use Illuminate\Http\Request;

class RkbmnDeletionController extends Controller
{
    public function index()
    {
        $deletions = RkbmnDeletion::with('asset')->latest()->paginate(10);
        return view('rkbmn.deletions.index', compact('deletions'));
    }

    public function create()
    {
        $assets = [];
        return view('rkbmn.deletions.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2025|max:2030',
            'asset_id' => 'required|exists:assets,id',
            'deletion_type' => 'required|string', // Rusak Berat, Hilang, dll
            'justification' => 'required|string',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();
        $data['status'] = 'draft';

        RkbmnDeletion::create($data);

        return redirect()->route('rkbmn.deletions.index')->with('success', 'Usulan Penghapusan berhasil direkam.');
    }

    public function show(RkbmnDeletion $deletion)
    {
        return view('rkbmn.deletions.show', compact('deletion'));
    }

    public function edit(RkbmnDeletion $deletion)
    {
        $assets = [];
        return view('rkbmn.deletions.edit', compact('deletion', 'assets'));
    }

    public function update(Request $request, RkbmnDeletion $deletion)
    {
        $request->validate([
            'year' => 'required|integer|min:2025|max:2030',
            'asset_id' => 'required|exists:assets,id',
            'deletion_type' => 'required|string',
            'justification' => 'required|string',
        ]);

        $deletion->update($request->all());

        return redirect()->route('rkbmn.deletions.index')->with('success', 'Usulan berhasil diperbarui.');
    }

    public function destroy(RkbmnDeletion $deletion)
    {
        $deletion->delete();
        return redirect()->route('rkbmn.deletions.index')->with('success', 'Usulan berhasil dihapus.');
    }
}
