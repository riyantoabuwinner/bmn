@extends('adminlte::page')

@section('title', 'Daftar Penghapusan Aset')

@section('content_header')
    <h1>Daftar Penghapusan Aset</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Usulan Penghapusan</h3>
            <div class="card-tools">
                <a href="{{ route('deletions.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Buat Usulan Baru
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Usulan</th>
                        <th>Aset</th>
                        <th>Tipe</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deletions as $deletion)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $deletion->proposal_date->format('d/m/Y') }}</td>
                            <td>
                                {{ $deletion->asset->kode_barang ?? '-' }} <br>
                                <small>{{ $deletion->asset->nama_barang ?? 'Aset tidak ditemukan' }}</small>
                            </td>
                            <td>
                                @if($deletion->asset_type == 'App\Models\AsetTetap')
                                    <span class="badge badge-info">Aset Tetap</span>
                                @elseif($deletion->asset_type == 'App\Models\AsetLainnya')
                                    <span class="badge badge-warning">Aset Lainnya</span>
                                @else
                                    <span class="badge badge-secondary">Lainnya</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($deletion->reason, 50) }}</td>
                            <td>
                                @if($deletion->status == 'pending')
                                    <span class="badge badge-warning">Menunggu Persetujuan</span>
                                @elseif($deletion->status == 'approved')
                                    <span class="badge badge-success">Disetujui</span>
                                    <br><small>{{ $deletion->approval_date ? $deletion->approval_date->format('d/m/Y') : '' }}</small>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('deletions.show', $deletion) }}" class="btn btn-xs btn-info">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                @if($deletion->status == 'pending')
                                    <form action="{{ route('deletions.destroy', $deletion) }}" method="POST" class="d-inline" onsubmit="return confirm('Batalkan usulan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i> Batal</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data penghapusan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $deletions->links() }}
            </div>
        </div>
    </div>
@stop
