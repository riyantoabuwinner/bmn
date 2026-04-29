<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetLocation;
use App\Models\Unit;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Imports\AssetImport;
use App\Exports\AssetsExport;

class AssetController extends Controller
{
    public function import(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        set_time_limit(0);

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:102400', // 100MB max
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('imports', $filename);

        $task = \App\Models\ImportTask::create([
            'type' => 'asset',
            'filename' => $file->getClientOriginalName(),
            'status' => 'pending',
            'user_id' => auth()->id(),
        ]);

        session(['asset_import_task_id' => $task->id]);

        Excel::queueImport(new AssetImport($task->id), $path);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'import_assets',
            'description' => "Memulai import aset SIMAN v2 di background",
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'task_id' => $task->id,
            'message' => 'Import SIMAN v2 sedang diproses di background.'
        ]);
    }

    public function export(Request $request)
    {
        ini_set('memory_limit', '2048M');
        set_time_limit(0);

        return Excel::download(new AssetsExport, 'data_aset.xlsx');
    }

    public function downloadTemplate()
    {
        return Excel::download(new \App\Exports\AssetSimanTemplateExport, 'template_import_siman_v2.xlsx');
    }

    public function index(Request $request)
    {
        $query = Asset::query();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;

            // For numeric searches, also try searching without formatting
            $numericSearch = preg_replace('/[.,\s]/', '', $search);
            $isNumericSearch = is_numeric($numericSearch);

            $query->where(function ($q) use ($search, $numericSearch, $isNumericSearch) {
                // Core fields
                $q->where('nama_barang', 'like', '%' . $search . '%')
                    ->orWhere('kode_barang', 'like', '%' . $search . '%')
                    ->orWhere('nup', 'like', '%' . $search . '%')
                    ->orWhere('merk', 'like', '%' . $search . '%')
                    ->orWhere('tipe', 'like', '%' . $search . '%')
                    ->orWhere('no_bukti', 'like', '%' . $search . '%')
                    ->orWhere('kode_satker', 'like', '%' . $search . '%')
                    ->orWhere('nama_satker', 'like', '%' . $search . '%');

                // Status & Legal
                $q->orWhere('status_pemanfaatan', 'like', '%' . $search . '%')
                    ->orWhere('status_bmn', 'like', '%' . $search . '%')
                    ->orWhere('no_psp', 'like', '%' . $search . '%')
                    ->orWhere('sip_number', 'like', '%' . $search . '%')
                    ->orWhere('status_sbsn', 'like', '%' . $search . '%')
                    ->orWhere('status_bmn_idle', 'like', '%' . $search . '%')
                    ->orWhere('status_kemitraan', 'like', '%' . $search . '%');

                // Address & Location Details
                $q->orWhere('alamat', 'like', '%' . $search . '%')
                    ->orWhere('rt_rw', 'like', '%' . $search . '%')
                    ->orWhere('desa_kel', 'like', '%' . $search . '%')
                    ->orWhere('kecamatan', 'like', '%' . $search . '%')
                    ->orWhere('kab_kota', 'like', '%' . $search . '%')
                    ->orWhere('provinsi', 'like', '%' . $search . '%')
                    ->orWhere('kode_pos', 'like', '%' . $search . '%');

                // Organization & Hierarchy
                $q->orWhere('nama_kl', 'like', '%' . $search . '%')
                    ->orWhere('nama_e1', 'like', '%' . $search . '%')
                    ->orWhere('nama_korwil', 'like', '%' . $search . '%')
                    ->orWhere('kode_kpknl', 'like', '%' . $search . '%')
                    ->orWhere('uraian_kpknl', 'like', '%' . $search . '%')
                    ->orWhere('uraian_kanwil', 'like', '%' . $search . '%')
                    ->orWhere('pengguna', 'like', '%' . $search . '%')
                    ->orWhere('penghuni', 'like', '%' . $search . '%');

                // Numeric / Financial Fields (Values)
                // If the search looks numeric, search with unformatted version
                if ($isNumericSearch) {
                    $q->orWhere('nilai_perolehan', 'like', '%' . $numericSearch . '%')
                        ->orWhere('nilai_buku', 'like', '%' . $numericSearch . '%')
                        ->orWhere('nilai_perolehan_pertama', 'like', '%' . $numericSearch . '%')
                        ->orWhere('nilai_mutasi', 'like', '%' . $numericSearch . '%')
                        ->orWhere('nilai_penyusutan', 'like', '%' . $numericSearch . '%')
                        ->orWhere('kuantitas', 'like', '%' . $numericSearch . '%');
                }
                else {
                    // Still search as-is for non-numeric searches
                    $q->orWhere('nilai_perolehan', 'like', '%' . $search . '%')
                        ->orWhere('nilai_buku', 'like', '%' . $search . '%')
                        ->orWhere('nilai_perolehan_pertama', 'like', '%' . $search . '%')
                        ->orWhere('nilai_mutasi', 'like', '%' . $search . '%')
                        ->orWhere('nilai_penyusutan', 'like', '%' . $search . '%')
                        ->orWhere('kuantitas', 'like', '%' . $search . '%');
                }

                // Misc
                $q->orWhere('keterangan', 'like', '%' . $search . '%')
                    ->orWhere('kode_register', 'like', '%' . $search . '%')
                    ->orWhere('jenis_dokumen', 'like', '%' . $search . '%')
                    ->orWhere('no_dokumen', 'like', '%' . $search . '%')
                    ->orWhere('no_sertifikat', 'like', '%' . $search . '%')
                    ->orWhere('nama_sertifikat', 'like', '%' . $search . '%')
                    ->orWhere('nama_pengguna_siman', 'like', '%' . $search . '%')
                    ->orWhere('lokasi_ruang', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        if ($request->filled('tahun_perolehan')) {
            $query->whereYear('tgl_perolehan_pertama', $request->tahun_perolehan);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Get total count before pagination
        $totalFiltered = $query->count();

        // Pagination with configurable per_page
        $perPage = $request->get('per_page', 20); // Default 20
        $assets = $query->latest()->paginate($perPage)->withQueryString();

        // Fetch categories for filter dropdown
        $categories = AssetCategory::orderBy('name')->get();

        return view('assets.index', compact('assets', 'totalFiltered', 'categories'));
    }

    public function create()
    {
        $locations = AssetLocation::all();
        $units = Unit::all();
        $categories = AssetCategory::orderBy('name')->get();
        return view('assets.create', compact('locations', 'units', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_satker' => 'nullable|string',
            'nama_satker' => 'nullable|string',
            'kode_barang' => 'required|string|max:50',
            'nama_barang' => 'required|string|max:255',
            'nup' => 'required|integer',
            'merk' => 'nullable|string|max:255',
            'tipe' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:asset_categories,id',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'intra_ekstra' => 'nullable|string',
            'tgl_perolehan_pertama' => 'nullable|date',
            'tgl_buku' => 'nullable|date',
            'tgl_buku_pertama' => 'nullable|date',
            'tgl_pengapusan' => 'nullable|date',
            'tgl_psp' => 'nullable|date',
            'nilai_perolehan' => 'required|numeric|min:0',
            'nilai_perolehan_pertama' => 'nullable|numeric|min:0',
            'nilai_mutasi' => 'nullable|numeric',
            'nilai_penyusutan' => 'nullable|numeric',
            'nilai_buku' => 'nullable|numeric',
            'kuantitas' => 'required|integer|min:1',
            'satuan' => 'required|string',
            'lokasi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'rt_rw' => 'nullable|string',
            'desa_kel' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kab_kota' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kode_pos' => 'nullable|string',
            'status_pemanfaatan' => 'nullable|string',
            'status_bmn' => 'nullable|string',
            'status_sbsn' => 'nullable|string',
            'status_bmn_idle' => 'nullable|string',
            'status_kemitraan' => 'nullable|string',
            'no_psp' => 'nullable|string',
            'sip_number' => 'nullable|string',
            'no_bukti' => 'nullable|string',
            'cara_perolehan' => 'nullable|string',
            'kode_register' => 'nullable|string',
            'luas' => 'nullable|numeric',
            'luas_tanah_bangunan' => 'nullable|numeric',
            'luas_tanah_sarana' => 'nullable|numeric',
            'luas_lahan_kosong' => 'nullable|numeric',
            'luas_bangunan' => 'nullable|numeric',
            'lahan_kosong' => 'nullable|string',
            'jumlah_lantai' => 'nullable|integer',
            'kode_kpknl' => 'nullable|string',
            'uraian_kpknl' => 'nullable|string',
            'uraian_kanwil' => 'nullable|string',
            'nama_kl' => 'nullable|string',
            'nama_e1' => 'nullable|string',
            'nama_korwil' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            
            // SIMAN v2 Fields
            'jenis_dokumen' => 'nullable|string',
            'no_dokumen' => 'nullable|string',
            'no_bpkp' => 'nullable|string',
            'no_polisi' => 'nullable|string',
            'status_sertifikasi' => 'nullable|string',
            'jenis_sertifikat' => 'nullable|string',
            'no_sertifikat' => 'nullable|string',
            'nama_sertifikat' => 'nullable|string',
            'no_stnk' => 'nullable|string',
            'status_pmk' => 'nullable|string',
            'henti_guna' => 'nullable|string',
            'bpybds' => 'nullable|string',
            'usulan_barang_hilang' => 'nullable|string',
            'usulan_barang_rb' => 'nullable|string',
            'usulan_hapus' => 'nullable|string',
            'hibah_dktp' => 'nullable|string',
            'konsensi_jasa' => 'nullable|string',
            'properti_investasi' => 'nullable|string',
            'lokasi_ruang' => 'nullable|string',
            'jenis_identitas' => 'nullable|string',
            'no_identitas' => 'nullable|string',
            'nama_pengguna_siman' => 'nullable|string',
            'masa_manfaat' => 'nullable|string',
            'sisa_masa_manfaat' => 'nullable|integer',
            'extra_info' => 'nullable|string',
            'tgl_dokumen' => 'nullable|date',
            'usulan_rusak_berat' => 'nullable|string',
            'tgl_sertifikat' => 'nullable|date',
            'masa_berlaku' => 'nullable|date',
            'nama_pemegang_hak' => 'nullable|string',
        ]);

        // Generate QR Code content if not provided (default matches Kode Barang + NUP)
        $validated['qr_code'] = $validated['kode_barang'] . '.' . $validated['nup'];

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('assets', 'public');
        }

        $asset = Asset::create($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'create_asset',
            'description' => "Menambah aset SIMAN: {$asset->nama_barang} ({$asset->kode_barang})",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('assets.index')
            ->with('success', 'Aset berhasil ditambahkan.');
    }

    public function show(Asset $asset)
    {
        $asset->load('category');
        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        $locations = AssetLocation::all();
        $units = Unit::all();
        $categories = AssetCategory::orderBy('name')->get();
        return view('assets.edit', compact('asset', 'locations', 'units', 'categories'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'kode_satker' => 'nullable|string',
            'nama_satker' => 'nullable|string',
            'kode_barang' => 'required|string|max:50',
            'nama_barang' => 'required|string|max:255',
            'nup' => 'required|integer',
            'merk' => 'nullable|string|max:255',
            'tipe' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:asset_categories,id',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'intra_ekstra' => 'nullable|string',
            'tgl_perolehan_pertama' => 'nullable|date',
            'tgl_buku' => 'nullable|date',
            'tgl_buku_pertama' => 'nullable|date',
            'tgl_pengapusan' => 'nullable|date',
            'tgl_psp' => 'nullable|date',
            'nilai_perolehan' => 'required|numeric|min:0',
            'nilai_perolehan_pertama' => 'nullable|numeric|min:0',
            'nilai_mutasi' => 'nullable|numeric',
            'nilai_penyusutan' => 'nullable|numeric',
            'nilai_buku' => 'nullable|numeric',
            'kuantitas' => 'required|integer|min:1',
            'satuan' => 'required|string',
            'lokasi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'rt_rw' => 'nullable|string',
            'desa_kel' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kab_kota' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kode_pos' => 'nullable|string',
            'status_pemanfaatan' => 'nullable|string',
            'status_bmn' => 'nullable|string',
            'status_sbsn' => 'nullable|string',
            'status_bmn_idle' => 'nullable|string',
            'status_kemitraan' => 'nullable|string',
            'no_psp' => 'nullable|string',
            'sip_number' => 'nullable|string',
            'no_bukti' => 'nullable|string',
            'cara_perolehan' => 'nullable|string',
            'kode_register' => 'nullable|string',
            'luas' => 'nullable|numeric',
            'luas_tanah_bangunan' => 'nullable|numeric',
            'luas_tanah_sarana' => 'nullable|numeric',
            'luas_lahan_kosong' => 'nullable|numeric',
            'luas_bangunan' => 'nullable|numeric',
            'lahan_kosong' => 'nullable|string',
            'jumlah_lantai' => 'nullable|integer',
            'kode_kpknl' => 'nullable|string',
            'uraian_kpknl' => 'nullable|string',
            'uraian_kanwil' => 'nullable|string',
            'nama_kl' => 'nullable|string',
            'nama_e1' => 'nullable|string',
            'nama_korwil' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            
            // SIMAN v2 Fields
            'jenis_dokumen' => 'nullable|string',
            'no_dokumen' => 'nullable|string',
            'no_bpkp' => 'nullable|string',
            'no_polisi' => 'nullable|string',
            'status_sertifikasi' => 'nullable|string',
            'jenis_sertifikat' => 'nullable|string',
            'no_sertifikat' => 'nullable|string',
            'nama_sertifikat' => 'nullable|string',
            'no_stnk' => 'nullable|string',
            'status_pmk' => 'nullable|string',
            'henti_guna' => 'nullable|string',
            'bpybds' => 'nullable|string',
            'usulan_barang_hilang' => 'nullable|string',
            'usulan_barang_rb' => 'nullable|string',
            'usulan_hapus' => 'nullable|string',
            'hibah_dktp' => 'nullable|string',
            'konsensi_jasa' => 'nullable|string',
            'properti_investasi' => 'nullable|string',
            'lokasi_ruang' => 'nullable|string',
            'jenis_identitas' => 'nullable|string',
            'no_identitas' => 'nullable|string',
            'nama_pengguna_siman' => 'nullable|string',
            'masa_manfaat' => 'nullable|string',
            'sisa_masa_manfaat' => 'nullable|integer',
            'extra_info' => 'nullable|string',
            'tgl_dokumen' => 'nullable|date',
            'usulan_rusak_berat' => 'nullable|string',
            'tgl_sertifikat' => 'nullable|date',
            'masa_berlaku' => 'nullable|date',
            'nama_pemegang_hak' => 'nullable|string',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($asset->photo) {
                \Storage::disk('public')->delete($asset->photo);
            }
            $validated['photo'] = $request->file('photo')->store('assets', 'public');
        }

        $asset->update($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'update_asset',
            'description' => "Memperbarui aset: {$asset->nama_barang}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('assets.index')
            ->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        try {
            if ($asset->photo) {
                \Storage::disk('public')->delete($asset->photo);
            }

            $name = $asset->nama_barang;
            $asset->delete();

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'delete_asset',
                'description' => "Menghapus aset: {$name}",
                'ip_address' => request()->ip(),
            ]);

            return redirect()->route('assets.index')
                ->with('success', 'Aset berhasil dihapus.');
        }
        catch (\Exception $e) {
            return redirect()->route('assets.index')
                ->with('error', 'Gagal menghapus aset: ' . $e->getMessage());
        }
    }

    public function scanner()
    {
        return view('assets.scan');
    }

    public function scanQr($qr_code)
    {
        // Try searching by specific QR code field first
        $asset = Asset::where('qr_code', $qr_code)->first();

        // If not found, try searching by kode_barang (SIMAN V2)
        if (!$asset) {
            $asset = Asset::where('kode_barang', $qr_code)->first();
        }

        // Check columns that might contain the code
        if (!$asset) {
            $asset = Asset::where('nup', $qr_code)->first();
        }

        if (!$asset) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code/Aset tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $asset->id,
                'kode_barang' => $asset->kode_barang,
                'nup' => $asset->nup,
                'nama_barang' => $asset->nama_barang,
                'merk_type' => $asset->merk_type,
                'kondisi' => $asset->kondisi,
                'lokasi' => $asset->lokasi,
                'tahun' => optional($asset->tgl_perolehan_pertama)->format('Y') ?? '-',
                'photo' => $asset->photo ? asset('storage/' . $asset->photo) : null,
            ]
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->get('q');
        $assets = Asset::where('nama_barang', 'like', "%$search%")
            ->orWhere('kode_barang', 'like', "%$search%")
            ->orWhere('nup', 'like', "%$search%")
            ->limit(20)
            ->get();

        $results = [];
        foreach ($assets as $asset) {
            $results[] = [
                'id' => $asset->id,
                'text' => $asset->nama_barang . ' - ' . $asset->kode_barang . ' (' . $asset->kondisi . ')'
            ];
        }

        return response()->json($results);
    }

    public function updateInventory(Asset $asset, Request $request)
    {
        $asset->update(['last_inventory_at' => now()]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'update_inventory',
            'description' => "Pemutakhiran Inventarisasi (Sensus) Aset: {$asset->nama_barang}",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Data inventarisasi aset berhasil dimutakhirkan.');
    }

    public function checkImportProgress()
    {
        $id = session('asset_import_task_id');
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
            'current_total' => Asset::count()
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
            
            // Delete photos if they exist
            $assets = Asset::whereIn('id', $ids)->get();
            foreach ($assets as $asset) {
                if ($asset->photo) {
                    \Storage::disk('public')->delete($asset->photo);
                }
            }

            Asset::whereIn('id', $ids)->delete();

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'bulk_delete_assets',
                'description' => "Menghapus {$count} aset sekaligus",
                'ip_address' => $request->ip(),
            ]);

            return response()->json(['success' => true, 'message' => "{$count} aset berhasil dihapus."]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus aset: ' . $e->getMessage()], 500);
        }
    }

    public function clearImportSession()
    {
        session()->forget('asset_import_task_id');
        return response()->json(['success' => true]);
    }
}
