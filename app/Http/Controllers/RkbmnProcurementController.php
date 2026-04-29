<?php

namespace App\Http\Controllers;

use App\Models\RkbmnProcurement;
use Illuminate\Http\Request;

class RkbmnProcurementController extends Controller
{
    public function index()
    {
        $procurements = RkbmnProcurement::latest()->paginate(10);
        return view('rkbmn.procurements.index', compact('procurements'));
    }

    public function create()
    {
        return view('rkbmn.procurements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2025|max:2030',
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string',
            'estimated_unit_price' => 'required|numeric|min:0',
            'priority' => 'required|in:Tinggi,Sedang,Rendah',
            'justification' => 'required|string',
        ]);

        $data = $request->all();
        $data['total_price'] = $data['quantity'] * $data['estimated_unit_price'];
        $data['created_by'] = auth()->id();
        $data['status'] = 'draft';

        RkbmnProcurement::create($data);

        return redirect()->route('rkbmn.procurements.index')->with('success', 'Usulan Pengadaan berhasil direkam.');
    }

    public function show(RkbmnProcurement $procurement)
    {
        return view('rkbmn.procurements.show', compact('procurement'));
    }

    public function edit(RkbmnProcurement $procurement)
    {
        return view('rkbmn.procurements.edit', compact('procurement'));
    }

    public function update(Request $request, RkbmnProcurement $procurement)
    {
        $request->validate([
            'year' => 'required|integer|min:2025|max:2030',
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string',
            'estimated_unit_price' => 'required|numeric|min:0',
            'priority' => 'required|in:Tinggi,Sedang,Rendah',
            'justification' => 'required|string',
        ]);

        $data = $request->all();
        $data['total_price'] = $data['quantity'] * $data['estimated_unit_price'];

        $procurement->update($data);

        return redirect()->route('rkbmn.procurements.index')->with('success', 'Usulan Pengadaan berhasil diperbarui.');
    }

    public function destroy(RkbmnProcurement $procurement)
    {
        $procurement->delete();
        return redirect()->route('rkbmn.procurements.index')->with('success', 'Usulan Pengadaan berhasil dihapus.');
    }
}
