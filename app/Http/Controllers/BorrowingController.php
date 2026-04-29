<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Asset;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['asset', 'approvedBy'])
            ->latest()
            ->paginate(20);

        return view('borrowings.index', compact('borrowings'));
    }

    public function pendingRequests(Request $request)
    {
        // Removed asset.category eagerly load as category might be gone or different
        $query = Borrowing::with(['asset', 'requester', 'approvedBy']);

        // Filter by status - default to pending
        $status = $request->get('status', 'pending');
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $borrowings = $query->latest()->paginate(20);

        return view('admin.loan-requests', compact('borrowings', 'status'));
    }

    public function create()
    {
        // Allow borrowing if condition is not 'Rusak Berat' and available (not borrowed)
        $assets = Asset::where('kondisi', '!=', 'Rusak Berat')
            ->where(function ($q) {
            $q->whereNull('status_pemanfaatan')
                ->orWhere('status_pemanfaatan', 'Digunakan Sendiri');
        })
            ->get();

        return view('borrowings.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'borrower_name' => 'required|string|max:255',
            'borrower_phone' => 'required|string|max:20',
            'borrower_email' => 'nullable|email',
            'borrow_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:borrow_date',
            'purpose' => 'required|string',
        ]);

        // Check asset availability
        $asset = Asset::findOrFail($validated['asset_id']);
        // Simplified check
        if ($asset->kondisi == 'Rusak Berat') {
            return back()->withErrors(['asset_id' => 'Aset rusak berat tidak dapat dipinjam.']);
        }

        $validated['status'] = 'pending';
        $validated['requested_by'] = auth()->id();

        $borrowing = Borrowing::create($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'create_borrowing',
            'description' => "Mengajukan peminjaman aset: {$asset->nama_barang} untuk {$borrowing->borrower_name}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('borrowings.index')
            ->with('success', 'Permohonan peminjaman berhasil diajukan dan menunggu persetujuan.');
    }

    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['asset', 'approvedBy', 'payment']);
        return view('borrowings.show', compact('borrowing'));
    }

    public function approve(Borrowing $borrowing)
    {
        if ($borrowing->status != 'pending') {
            return back()->with('error', 'Peminjaman ini sudah diproses.');
        }

        $borrowing->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        // Update asset status
        $borrowing->asset->update(['status_pemanfaatan' => 'Dipinjam']);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'approve_borrowing',
            'description' => "Menyetujui peminjaman aset: {$borrowing->asset->nama_barang} oleh {$borrowing->borrower_name}",
            'ip_address' => request()->ip(),
        ]);

        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function reject(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->status != 'pending') {
            return back()->with('error', 'Peminjaman ini sudah diproses.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $borrowing->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'notes' => $validated['rejection_reason'],
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'reject_borrowing',
            'description' => "Menolak peminjaman aset: {$borrowing->asset->nama_barang} - {$validated['rejection_reason']}",
            'ip_address' => request()->ip(),
        ]);

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    public function returnAsset(Borrowing $borrowing)
    {
        if ($borrowing->status != 'approved' || $borrowing->returned_at) {
            return back()->with('error', 'Peminjaman ini tidak valid untuk pengembalian.');
        }

        $borrowing->update([
            'returned_at' => now(),
        ]);

        // Update asset status back to available
        $borrowing->asset->update(['status_pemanfaatan' => 'Digunakan Sendiri']);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'return_borrowing',
            'description' => "Mengembalikan aset: {$borrowing->asset->nama_barang} dari {$borrowing->borrower_name}",
            'ip_address' => request()->ip(),
        ]);

        return back()->with('success', 'Aset berhasil dikembalikan.');
    }

    public function destroy(Borrowing $borrowing)
    {
        if ($borrowing->status == 'approved' && !$borrowing->returned_at) {
            return back()->with('error', 'Tidak dapat menghapus peminjaman yang sedang aktif.');
        }

        $borrowing->delete();

        return redirect()->route('borrowings.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
