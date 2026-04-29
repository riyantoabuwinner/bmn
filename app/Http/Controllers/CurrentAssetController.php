<?php

namespace App\Http\Controllers;

use App\Models\CurrentAsset;
use App\Models\CurrentAssetCategory;
use App\Models\Unit;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CurrentAssetsExport;
use App\Imports\CurrentAssetsImport;
use App\Exports\CurrentAssetTemplateExport;

class CurrentAssetController extends Controller
{
    public function import(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        set_time_limit(0);

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:102400', // 100MB
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('imports', $filename);

        $task = \App\Models\ImportTask::create([
            'type' => 'current_asset',
            'filename' => $file->getClientOriginalName(),
            'status' => 'pending',
            'user_id' => auth()->id(),
        ]);

        session(['current_asset_import_task_id' => $task->id]);

        Excel::queueImport(new \App\Imports\CurrentAssetsImport($task->id), $path);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'import_current_assets',
            'description' => "Memulai import aset lancar di background",
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'task_id' => $task->id,
            'message' => 'Import aset lancar sedang diproses di background.'
        ]);
    }

    public function export()
    {
        return Excel::download(new CurrentAssetsExport, 'data_aset_lancar.xlsx');
    }

    public function downloadTemplate()
    {
        return Excel::download(new CurrentAssetTemplateExport, 'template_import_aset_lancar.xlsx');
    }

    public function index(Request $request)
    {
        $query = CurrentAsset::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                    ->orWhere('kode_barang', 'like', '%' . $search . '%')
                    ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        // Filter by category_id
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        // Fallback for string filtering if still used in some views
        elseif ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter low stock
        if ($request->filled('low_stock') && $request->low_stock == '1') {
            $query->whereRaw('stok_tersedia <= stok_minimum');
        }

        $totalFiltered = $query->count();
        $perPage = $request->get('per_page', 20);
        $assets = $query->latest()->paginate($perPage)->withQueryString();

        return view('current_assets.index', compact('assets', 'totalFiltered'));
    }

    public function create()
    {
        $categories = CurrentAssetCategory::all();
        $units = Unit::all();
        return view('current_assets.create', compact('categories', 'units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'nullable|string',
            'stok_awal' => 'required|integer|min:0',
            'stok_minimum' => 'nullable|integer|min:0',
            'harga_satuan' => 'required|numeric|min:0',
            'tanggal_perolehan' => 'nullable|date',
            'sumber_dana' => 'nullable|string',
            'lokasi_penyimpanan' => 'nullable|string',
            'satuan' => 'required|string',
            'spesifikasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'unit_id' => 'nullable|exists:units,id',
            'category_id' => 'nullable|exists:current_asset_categories,id',
        ]);

        $validated['stok_tersedia'] = $validated['stok_awal'];
        $validated['nilai_total'] = $validated['stok_awal'] * $validated['harga_satuan'];

        $asset = CurrentAsset::create($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'create_current_asset',
            'description' => "Menambah aset lancar: {$asset->nama_barang}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('current-assets.index')
            ->with('success', 'Aset lancar berhasil ditambahkan.');
    }

    public function show(CurrentAsset $currentAsset)
    {
        return view('current_assets.show', compact('currentAsset'));
    }

    public function edit(CurrentAsset $currentAsset)
    {
        $categories = CurrentAssetCategory::all();
        $units = Unit::all();
        return view('current_assets.edit', compact('currentAsset', 'categories', 'units'));
    }

    public function update(Request $request, CurrentAsset $currentAsset)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'nullable|string',
            'stok_minimum' => 'nullable|integer|min:0',
            'harga_satuan' => 'required|numeric|min:0',
            'tanggal_perolehan' => 'nullable|date',
            'sumber_dana' => 'nullable|string',
            'lokasi_penyimpanan' => 'nullable|string',
            'satuan' => 'required|string',
            'spesifikasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'unit_id' => 'nullable|exists:units,id',
            'category_id' => 'nullable|exists:current_asset_categories,id',
        ]);

        $currentAsset->update($validated);
        $currentAsset->updateStock(); // Recalculate nilai_total

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'update_current_asset',
            'description' => "Memperbarui aset lancar: {$currentAsset->nama_barang}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('current-assets.index')
            ->with('success', 'Aset lancar berhasil diperbarui.');
    }

    public function destroy(CurrentAsset $currentAsset)
    {
        $name = $currentAsset->nama_barang;
        $currentAsset->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete_current_asset',
            'description' => "Menghapus aset lancar: {$name}",
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('current-assets.index')
            ->with('success', 'Aset lancar berhasil dihapus.');
    }

    public function adjustStock(Request $request, $id)
    {
        $asset = CurrentAsset::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        try {
            if ($validated['type'] === 'in') {
                $asset->addStock($validated['quantity'], $validated['keterangan']);
                $message = 'Stok berhasil ditambahkan.';
            }
            else {
                $asset->reduceStock($validated['quantity'], $validated['keterangan']);
                $message = 'Stok berhasil dikurangi.';
            }

            return redirect()->back()->with('success', $message);
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function checkImportProgress()
    {
        $id = session('current_asset_import_task_id');
        if (!$id) {
            return response()->json(['error' => 'No active import'], 404);
        }

        $task = \App\Models\ImportTask::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        return response()->json([
            'id' => $id,
            'total' => $task->total_rows,
            'processed' => $task->processed_rows,
            'percentage' => $task->progress,
            'finished' => in_array($task->status, ['completed', 'failed']),
            'status' => $task->status,
            'error' => $task->error_message,
            'current_total' => CurrentAsset::count()
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!is_array($ids) || count($ids) === 0) {
            return response()->json(['success' => false, 'message' => 'Tidak ada data yang dipilih.'], 400);
        }

        try {
            $count = count($ids);
            CurrentAsset::whereIn('id', $ids)->delete();

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'bulk_delete_current_assets',
                'description' => "Menghapus {$count} aset lancar sekaligus",
                'ip_address' => $request->ip(),
            ]);

            return response()->json(['success' => true, 'message' => "{$count} aset lancar berhasil dihapus."]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus aset lancar: ' . $e->getMessage()], 500);
        }
    }

    public function clearImportSession()
    {
        session()->forget('current_asset_import_task_id');
        return response()->json(['success' => true]);
    }
}
