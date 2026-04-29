<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::with('parent')->orderBy('type')->orderBy('name')->get();
        return view('units.index', compact('units'));
    }

    public function create()
    {
        $parentUnits = Unit::whereIn('type', ['rektorat', 'fakultas'])->get();
        return view('units.create', compact('parentUnits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:rektorat,fakultas,unit_kerja',
            'parent_id' => 'nullable|exists:units,id',
        ]);

        Unit::create($validated);

        return redirect()->route('units.index')
            ->with('success', 'Unit berhasil ditambahkan.');
    }

    public function show(Unit $unit)
    {
        $unit->load('parent', 'children', 'users', 'assets');
        return view('units.show', compact('unit'));
    }

    public function edit(Unit $unit)
    {
        $parentUnits = Unit::whereIn('type', ['rektorat', 'fakultas'])
            ->where('id', '!=', $unit->id)
            ->get();
        return view('units.edit', compact('unit', 'parentUnits'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:rektorat,fakultas,unit_kerja',
            'parent_id' => 'nullable|exists:units,id',
        ]);

        $unit->update($validated);

        return redirect()->route('units.index')
            ->with('success', 'Unit berhasil diperbarui.');
    }

    public function destroy(Unit $unit)
    {
        try {
            $unit->delete();
            return redirect()->route('units.index')
                ->with('success', 'Unit berhasil dihapus.');
        }
        catch (\Exception $e) {
            return redirect()->route('units.index')
                ->with('error', 'Unit tidak dapat dihapus karena masih memiliki data terkait.');
        }
    }
}
