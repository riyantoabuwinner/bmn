<?php

namespace App\Http\Controllers;

use App\Models\CurrentAsset;
use App\Models\CurrentAssetTransaction;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CurrentAssetTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = CurrentAssetTransaction::with(['currentAsset', 'creator']);

        if ($request->filled('type')) {
            $query->where('transaction_type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->paginate(20);

        return view('current_assets.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $assets = CurrentAsset::orderBy('nama_barang')->get();
        return view('current_assets.transactions.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'current_asset_id' => 'required|exists:current_assets,id',
            'transaction_type' => 'required|in:purchase,transfer_in,grant_in,production,usage,transfer_out,grant_out,disposal,correction,opname',
            'reference_number' => 'required|string',
            'transaction_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'proof_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        $asset = CurrentAsset::findOrFail($validated['current_asset_id']);

        // Check stock availability for outflows (except opname/correction which might be adjustments)
        if (in_array($validated['transaction_type'], ['usage', 'transfer_out', 'grant_out', 'disposal'])) {
            if ($validated['quantity'] > $asset->stok_tersedia) {
                return back()->withErrors(['quantity' => "Stok tidak mencukupi. Tersedia: {$asset->stok_tersedia}"]);
            }
        }

        // Handle File Upload
        if ($request->hasFile('proof_document')) {
            $validated['proof_document'] = $request->file('proof_document')->store('transactions', 'public');
        }

        // Auto-fill price from master if not provided (for usage/outflows)
        if (empty($validated['unit_price'])) {
            $validated['unit_price'] = $asset->harga_satuan;
        }

        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];
        $validated['created_by'] = auth()->id();
        $validated['status'] = 'pending'; // Default SAKTI workflow starts as Pending/Draft

        $transaction = CurrentAssetTransaction::create($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'create_transaction',
            'description' => "Membuat transaksi {$validated['transaction_type']} untuk {$asset->nama_barang}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('current-asset-transactions.index')
            ->with('success', 'Transaksi berhasil dibuat dan menunggu persetujuan.');
    }

    public function show(CurrentAssetTransaction $transaction)
    {
        return view('current_assets.transactions.show', compact('transaction'));
    }

    public function action(Request $request, CurrentAssetTransaction $transaction)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes' => 'nullable|string'
        ]);

        if ($transaction->status != 'pending') {
            return back()->with('error', 'Transaksi sudah diproses sebelumnya.');
        }

        if ($request->action == 'approve') {
            DB::transaction(function () use ($transaction) {
                $transaction->update([
                    'status' => 'approved',
                    'approved_by' => auth()->id(),
                    'approved_at' => now(),
                ]);

                // Recalculate Master Stock
                $transaction->currentAsset->recalculateStock();
            });

            $message = 'Transaksi disetujui dan stok telah diperbarui.';
        }
        else {
            $transaction->update([
                'status' => 'rejected',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
            $message = 'Transaksi ditolak.';
        }

        return redirect()->route('current-asset-transactions.index')->with('success', $message);
    }
}
