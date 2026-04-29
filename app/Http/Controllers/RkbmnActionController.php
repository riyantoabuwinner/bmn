<?php

namespace App\Http\Controllers;

use App\Models\RkbmnAction;
use App\Models\Asset;
use Illuminate\Http\Request;

class RkbmnActionController extends Controller
{
    public function index()
    {
        $actions = RkbmnAction::with('asset')->latest()->paginate(10);
        return view('rkbmn.actions.index', compact('actions'));
    }

    public function create()
    {
        $assets = [];
        return view('rkbmn.actions.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2025|max:2030',
            'asset_id' => 'required|exists:assets,id',
            'action_type' => 'required|string', // Sewa, Jual, Hibah, dll
            'estimated_revenue' => 'required|numeric|min:0',
            'justification' => 'required|string',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();
        $data['status'] = 'draft';

        RkbmnAction::create($data);

        return redirect()->route('rkbmn.actions.index')->with('success', 'Usulan Pemanfaatan/Pemindahtanganan berhasil direkam.');
    }

    public function show(RkbmnAction $action)
    {
        return view('rkbmn.actions.show', compact('action'));
    }

    public function edit(RkbmnAction $action)
    {
        $assets = [];
        return view('rkbmn.actions.edit', compact('action', 'assets'));
    }

    public function update(Request $request, RkbmnAction $action)
    {
        $request->validate([
            'year' => 'required|integer|min:2025|max:2030',
            'asset_id' => 'required|exists:assets,id',
            'action_type' => 'required|string',
            'estimated_revenue' => 'required|numeric|min:0',
            'justification' => 'required|string',
        ]);

        $action->update($request->all());

        return redirect()->route('rkbmn.actions.index')->with('success', 'Usulan berhasil diperbarui.');
    }

    public function destroy(RkbmnAction $action)
    {
        $action->delete();
        return redirect()->route('rkbmn.actions.index')->with('success', 'Usulan berhasil dihapus.');
    }
}
