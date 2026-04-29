<?php

namespace App\Http\Controllers;

use App\Models\RoleRequest;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class RoleRequestController extends Controller
{
    public function create()
    {
        $units = Unit::all();
        // Roles available for request (excluding superadmin)
        $roles = Role::whereNotIn('name', ['superadmin', 'user'])->pluck('name');

        return view('role-requests.create', compact('units', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'requested_role' => 'required|string|exists:roles,name',
            'unit_id' => 'required_if:requested_role,operator_unit|nullable|exists:units,id',
            'sk_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'notes' => 'nullable|string|max:500',
        ]);

        $path = $request->file('sk_file')->store('sk_files', 'public');

        RoleRequest::create([
            'user_id' => auth()->id(),
            'requested_role' => $request->requested_role,
            'unit_id' => $request->unit_id,
            'sk_file' => $path,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('status', 'Permohonan role berhasil dikirim dan sedang menunggu persetujuan admin.');
    }

    public function index()
    {
        $requests = RoleRequest::with(['user', 'unit'])->where('status', 'pending')->latest()->get();
        return view('role-requests.index', compact('requests'));
    }

    public function approve(RoleRequest $roleRequest)
    {
        $user = $roleRequest->user;

        // Remove 'user' role and assign requested role
        $user->removeRole('user');
        $user->assignRole($roleRequest->requested_role);

        // Update user unit if applicable
        if ($roleRequest->unit_id) {
            $user->update(['unit_id' => $roleRequest->unit_id]);
        }

        // Approve user
        $user->update(['approval_status' => 'approved']);

        // Update request status
        $roleRequest->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Permohonan role disetujui.');
    }

    public function reject(Request $request, RoleRequest $roleRequest)
    {
        $request->validate(['rejection_reason' => 'required|string']);

        $roleRequest->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', 'Permohonan role ditolak.');
    }
}
