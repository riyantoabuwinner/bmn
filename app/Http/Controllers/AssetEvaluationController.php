<?php

namespace App\Http\Controllers;

use App\Models\AssetEvaluation;
use App\Models\AssetEvaluationDetail;
use App\Models\Asset;
use App\Models\AssetLocation; // For filtering if needed
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Added Log facade
use Barryvdh\DomPDF\Facade\Pdf;

class AssetEvaluationController extends Controller
{
    public function index()
    {
        $evaluations = AssetEvaluation::with('creator')->latest()->paginate(10);
        return view('evaluations.index', compact('evaluations'));
    }

    public function create()
    {
        return view('evaluations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1), // Updated validation
            'period_type' => 'required|in:semester,annual',
            'semester' => 'required_if:period_type,semester|nullable|in:1,2',
        ]);

        // Check for duplicates
        $exists = AssetEvaluation::where('year', $validated['year'])
            ->where('period_type', $validated['period_type'])
            ->when($validated['period_type'] == 'semester', function ($q) use ($validated) {
            return $q->where('semester', $validated['semester']);
        })
            ->exists();

        if ($exists) {
            return back()->with('error', 'Evaluasi untuk periode ini sudah ada.');
        }

        // Increase time limit for large data processing
        set_time_limit(300); // 5 minutes

        DB::beginTransaction();
        try {
            $evaluation = AssetEvaluation::create([
                'year' => $validated['year'],
                'period_type' => $validated['period_type'],
                'semester' => $validated['semester'] ?? null,
                'status' => 'draft',
                'created_by' => auth()->id(),
            ]);

            // Pre-populate details with all active assets?
            // This makes it easier for users to fill in. But might be slow if 1000s of assets.
            // Let's do it for better UX, assuming reasonable asset count (< 5000).

            // Optimized Batch Insert
            // Optimized Batch Insert
            // Select only active assets (not deleted, maybe filter by status if needed)
            $assets = \App\Models\Asset::select('id', 'kondisi')
                ->get();

            $chunks = $assets->chunk(1000);

            foreach ($chunks as $chunk) {
                $data = [];
                foreach ($chunk as $asset) {
                    $data[] = [
                        'asset_evaluation_id' => $evaluation->id,
                        'asset_id' => $asset->id,
                        'asset_type' => \App\Models\Asset::class , // Keep for compatibility if column exists
                        'condition_status' => $asset->kondisi,
                        'action_needed' => null,
                        'notes' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                AssetEvaluationDetail::insert($data);
            }

            // Optionally include AsetLainnya if requested? User said "Penghapusan aset tetap maupun aset lainnya", for Evaluation implied "Asset".
            // Let's stick to Fixed Assets primarily for now as per plan assumption, to keep it simple. 
            // If they want others, we can add later or add a button "Sync Assets".

            DB::commit();

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'create_evaluation',
                'description' => "Membuat periode evaluasi: {$evaluation->period_name}",
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('evaluations.edit', $evaluation)->with('success', 'Periode evaluasi dibuat. Silakan input hasil evaluasi.');
        }
        catch (\Exception $e) {
            DB::rollBack();
            \Log::error('AssetEvaluation Store Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat evaluasi: ' . $e->getMessage());
        }
    }

    public function edit(AssetEvaluation $evaluation)
    {
        if ($evaluation->status == 'finalized') {
            return redirect()->route('evaluations.show', $evaluation);
        }

        // Paginate details to avoid memory issues with 19k+ records
        $details = $evaluation->details()->with('asset')->paginate(50);
        return view('evaluations.edit', compact('evaluation', 'details'));
    }

    public function update(Request $request, AssetEvaluation $evaluation)
    {
        if ($evaluation->status == 'finalized') {
            return back()->with('error', 'Evaluasi sudah difinalisasi.');
        }

        // Validate bulk input
        $data = $request->validate([
            'details' => 'required|array',
            'details.*.condition_status' => 'required|string',
            'details.*.action_needed' => 'nullable|string',
            'details.*.notes' => 'nullable|string',
            'is_final' => 'nullable|boolean', // Checkbox to finalize
        ]);

        DB::beginTransaction();
        try {
            foreach ($data['details'] as $id => $detailData) {
                // Determine if condition changed
                $detail = AssetEvaluationDetail::find($id);
                if ($detail && $detail->asset_evaluation_id == $evaluation->id) {
                    $detail->update([
                        'condition_status' => $detailData['condition_status'],
                        'action_needed' => $detailData['action_needed'],
                        'notes' => $detailData['notes'],
                    ]);

                    // If finalizing, should we update the actual asset master data?
                    if ($request->has('is_final') && $request->is_final) {
                        // Update actual asset condition
                        if ($detail->asset) {
                            $detail->asset->update([
                                'condition_status' => $detailData['condition_status']
                            ]);
                        }
                    }
                }
            }

            if ($request->has('is_final') && $request->is_final) {
                $evaluation->update([
                    'status' => 'finalized',
                    'finalized_at' => now(),
                ]);
                $msg = 'Evaluasi berhasil disimpan dan DIFINALISASI. Data aset induk telah diperbarui.';
            }
            else {
                $msg = 'Progress evaluasi berhasil disimpan (Draft).';
            }

            DB::commit();
            return redirect()->route('evaluations.index')->with('success', $msg);

        }
        catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan evaluasi: ' . $e->getMessage());
        }
    }

    public function show(AssetEvaluation $evaluation)
    {
        $details = $evaluation->details()->with('asset')->get();
        return view('evaluations.show', compact('evaluation', 'details'));
    }

    public function print(AssetEvaluation $evaluation)
    {
        // Increase memory limit for PDF generation if many records
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $details = $evaluation->details()->with('asset')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('evaluations.print', compact('evaluation', 'details'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan-Evaluasi-' . $evaluation->year . '.pdf');
    }
}
