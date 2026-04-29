@extends('adminlte::page')

@section('title', 'Daftar Pemegang Aset')

@section('content_header')
    <h1><i class="fas fa-user-tag"></i> Daftar Pemegang Aset</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filter Data</h3>
            <div class="card-tools">
                <a href="{{ route('assignments.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Penyerahan
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('assignments.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari Nama / Kode Aset..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="status" class="form-control">
                                <option value="">-- Semua Status --</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Sedang Memegang</option>
                                <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Sudah Kembali</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i> Filter</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive mt-3">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Assign</th>
                            <th>Nama Pemegang</th>
                            <th>Aset</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments as $assignment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $assignment->assigned_date ? $assignment->assigned_date->format('d/m/Y') : '-' }}</td>
                                <td>
                                    <strong>{{ $assignment->employee_name }}</strong><br>
                                    <small class="text-muted">{{ $assignment->position ?? '-' }}</small>
                                </td>
                                <td>
                                    {{ $assignment->asset->kode_barang }}<br>
                                    <small>{{ $assignment->asset->nama_barang }}</small>
                                </td>
                                <td>
                                    @if($assignment->status == 'active')
                                        <span class="badge badge-success">Sedang Memegang</span>
                                    @else
                                        <span class="badge badge-secondary">Dikembalikan</span>
                                        <br><small>{{ $assignment->return_date ? $assignment->return_date->format('d/m/Y') : '' }}</small>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('assignments.show', $assignment) }}" class="btn btn-info btn-xs">
                                        <i class="fas fa-eye"></i> Detail/BAST
                                    </a>
                                    @if($assignment->status == 'active')
                                        <a href="{{ route('assignments.return', $assignment) }}" class="btn btn-warning btn-xs">
                                            <i class="fas fa-undo"></i> Kembali
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data pemegang aset.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $assignments->links() }}
            </div>
        </div>
    </div>
@stop
