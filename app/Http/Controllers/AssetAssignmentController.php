<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetAssignment;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AssetAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = AssetAssignment::with(['asset', 'user'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('employee_name', 'like', '%' . $request->search . '%')
                    ->orWhereHas('asset', function ($q2) use ($request) {
                    $q2->where('nama_barang', 'like', '%' . $request->search . '%')
                        ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
                });
            });
        }

        $assignments = $query->paginate(20)->withQueryString();

        return view('assignments.index', compact('assignments'));
    }

    public function create(Request $request)
    {
        // Only show assets that are available OR already assigned (to update/replace logic if needed)
        // For now, only available assets or those not currently 'assigned' in a way that blocks reassignment
        $assets = Asset::where('kondisi', '!=', 'Rusak Berat')
            ->where(function ($q) {
                $q->whereNull('status_pemanfaatan')
                  ->orWhere('status_pemanfaatan', 'Digunakan Sendiri');
            })
            ->orderBy('nama_barang')
            ->get();

        $users = User::orderBy('name')->get();

        $selected_asset_id = $request->query('asset_id');

        return view('assignments.create', compact('assets', 'users', 'selected_asset_id'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'user_id' => 'nullable|exists:users,id',
            'employee_name' => 'required_without:user_id|string|max:255',
            'employee_id_number' => 'nullable|string|max:50',
            'position' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'assigned_date' => 'required|date',
            'condition_on_assign' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Auto-fill from user if selected
        if ($request->filled('user_id')) {
            $user = User::find($request->user_id);
            $validated['employee_name'] = $user->name;
            if (!$request->filled('employee_id_number'))
                $validated['employee_id_number'] = $user->nip ?? null;
        }

        $asset = Asset::find($validated['asset_id']);
        // Check if asset is already assigned (using status prefix or relationship check if we added one)
        // Simple string check for now
        if ($asset->status_pemanfaatan && str_contains($asset->status_pemanfaatan, 'Digunakan oleh')) {
             return back()->with('error', 'Aset ini sedang digunakan oleh orang lain. Harap proses pengembalian terlebih dahulu.');
        }

        $assignment = AssetAssignment::create($validated);

        // Update Asset Status
        $asset->update(['status_pemanfaatan' => 'Digunakan oleh ' . $validated['employee_name']]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'assign_asset',
            'description' => "Menyerahkan aset: {$asset->nama_barang} kepada {$validated['employee_name']}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('assignments.show', $assignment)
            ->with('success', 'Berhasil mencatat pemegang aset. Silakan cetak BAST.');
    }

    public function show(AssetAssignment $assignment)
    {
        $assignment->load(['asset', 'user']);
        return view('assignments.show', compact('assignment'));
    }

    public function returnAsset(AssetAssignment $assignment)
    {
        if ($assignment->status == 'returned') {
            return redirect()->route('assignments.index')->with('error', 'Aset sudah dikembalikan.');
        }
        return view('assignments.return', compact('assignment'));
    }

    public function processReturn(Request $request, AssetAssignment $assignment)
    {
        $validated = $request->validate([
            'return_date' => 'required|date|after_or_equal:' . $assignment->assigned_date,
            'condition_on_return' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $assignment->update([
            'status' => 'returned',
            'return_date' => $validated['return_date'],
            'condition_on_return' => $validated['condition_on_return'],
            'notes' => $assignment->notes . "\n[Pengembalian] " . $validated['notes'],
        ]);

        // Update Asset Status
        // Map condition string to enum if needed, assuming user inputs valid enum or close to it
        $kondisi = 'Baik';
        if (str_contains(strtolower($validated['condition_on_return']), 'rusak berat')) $kondisi = 'Rusak Berat';
        elseif (str_contains(strtolower($validated['condition_on_return']), 'rusak')) $kondisi = 'Rusak Ringan';

        $assignment->asset->update([
            'status_pemanfaatan' => 'Digunakan Sendiri',
            'kondisi' => $kondisi,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'return_asset_assignment',
            'description' => "Pengembalian aset: {$assignment->asset->nama_barang} dari {$assignment->employee_name}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('assignments.index')
            ->with('success', 'Aset telah dikembalikan.');
    }

    public function print(AssetAssignment $assignment)
    {
        $assignment->load(['asset', 'user']);
        $pdf = Pdf::loadView('assignments.print', compact('assignment'));
        return $pdf->stream('BAST-' . $assignment->id . '.pdf');
    }
}
