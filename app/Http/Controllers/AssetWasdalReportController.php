<?php

namespace App\Http\Controllers;

use App\Models\AssetWasdalReport;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetWasdalReportController extends Controller
{
    public function index()
    {
        $reports = AssetWasdalReport::with('asset')->latest()->paginate(10);
        return view('wasdal.reports.index', compact('reports'));
    }

    public function create()
    {
        $assets = []; // AJAX search
        return view('wasdal.reports.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'period_year' => 'required|integer|min:2020|max:2030',
            'report_type' => 'required|string',
            'condition_status' => 'required|string',
            'usage_status' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('wasdal_reports', 'public');
        }

        AssetWasdalReport::create($data);

        return redirect()->route('wasdal-reports.index')->with('success', 'Pelaporan Wasdal berhasil disimpan.');
    }

    public function show(AssetWasdalReport $wasdal_report)
    {
        return view('wasdal.reports.show', ['report' => $wasdal_report]);
    }

    public function edit(AssetWasdalReport $wasdal_report)
    {
        $assets = [];
        return view('wasdal.reports.edit', ['report' => $wasdal_report, 'assets' => $assets]);
    }

    public function update(Request $request, AssetWasdalReport $wasdal_report)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'period_year' => 'required|integer',
            'report_type' => 'required|string',
            'condition_status' => 'required|string',
            'usage_status' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('wasdal_reports', 'public');
        }

        $wasdal_report->update($data);

        return redirect()->route('wasdal-reports.index')->with('success', 'Data Pelaporan berhasil diperbarui.');
    }

    public function destroy(AssetWasdalReport $wasdal_report)
    {
        $wasdal_report->delete();
        return redirect()->route('wasdal-reports.index')->with('success', 'Data Pelaporan berhasil dihapus.');
    }
}
