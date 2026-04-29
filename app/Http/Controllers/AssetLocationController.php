<?php

namespace App\Http\Controllers;

use App\Models\AssetLocation;
use App\Models\Unit;
use Illuminate\Http\Request;

class AssetLocationController extends Controller
{
    public function index()
    {
        $locations = AssetLocation::with('unit')->withCount('assets')->latest()->get();
        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        $units = Unit::all();
        return view('locations.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
        ]);

        AssetLocation::create($validated);

        return redirect()->route('locations.index')
            ->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function show(AssetLocation $location)
    {
        $location->load('unit', 'assets');
        return view('locations.show', compact('location'));
    }

    public function edit(AssetLocation $location)
    {
        $units = Unit::all();
        return view('locations.edit', compact('location', 'units'));
    }

    public function update(Request $request, AssetLocation $location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
        ]);

        $location->update($validated);

        return redirect()->route('locations.index')
            ->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(AssetLocation $location)
    {
        try {
            $location->delete();
            return redirect()->route('locations.index')
                ->with('success', 'Lokasi berhasil dihapus.');
        }
        catch (\Exception $e) {
            return redirect()->route('locations.index')
                ->with('error', 'Lokasi tidak dapat dihapus karena masih memiliki aset terkait.');
        }
    }
}
