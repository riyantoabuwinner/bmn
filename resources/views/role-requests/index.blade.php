@extends('adminlte::page')

@section('title', 'Daftar Permohonan Role')

@section('content_header')
    <h1>Permohonan Role Akses</h1>
@stop

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Daftar Pengajuan (Pending)</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 1%">#</th>
                    <th style="width: 20%">User</th>
                    <th style="width: 20%">Role Diminta</th>
                    <th style="width: 20%">Unit Kerja</th>
                    <th style="width: 10%">SK Penugasan</th>
                    <th>Catatan</th>
                    <th style="width: 20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $req)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a>{{ $req->user->name }}</a>
                            <br/>
                            <small>{{ $req->user->email }}</small>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $req->requested_role)) }}</span>
                        </td>
                        <td>
                            @if($req->unit)
                                {{ $req->unit->name }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ asset('storage/' . $req->sk_file) }}" target="_blank" class="btn btn-sm btn-default">
                                <i class="fas fa-file-pdf"></i> Lihat SK
                            </a>
                        </td>
                        <td>{{ $req->notes ?? '-' }}</td>
                        <td class="project-actions">
                            <form action="{{ route('role-requests.approve', $req->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui permohonan ini?')">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                            </form>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectModal{{ $req->id }}">
                                <i class="fas fa-times"></i> Reject
                            </button>

                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal{{ $req->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tolak Permohonan</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('role-requests.reject', $req->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Alasan Penolakan</label>
                                                    <textarea name="rejection_reason" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Tolak</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada permohonan pending.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop
