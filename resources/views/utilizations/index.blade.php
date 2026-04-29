@extends('adminlte::page')

@section('title', 'Daftar Pemanfaatan')

@section('content_header')
    <h1>Daftar Pemanfaatan Aset</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Pemanfaatan (Sewa, Pinjam Pakai, KSP)</h3>
            <div class="card-tools">
                <a href="{{ route('utilizations.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Rekam Pemanfaatan Baru
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Aset</th>
                        <th>Pihak Ketiga</th>
                        <th>Periode</th>
                        <th>Nilai (Rp)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($utilizations as $index => $item)
                        <tr>
                            <td>{{ $utilizations->firstItem() + $index }}</td>
                            <td>{{ $item->utilization_type }}</td>
                            <td>{{ $item->asset->nama_barang ?? 'N/A' }}</td>
                            <td>{{ $item->partner_name }}</td>
                            <td>
                                {{ $item->start_date->format('d/m/Y') }} s.d {{ $item->end_date->format('d/m/Y') }}
                            </td>
                            <td class="text-right">{{ number_format($item->value, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-{{ $item->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('utilizations.show', $item) }}" class="btn btn-info btn-xs" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('utilizations.edit', $item) }}" class="btn btn-warning btn-xs" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('utilizations.destroy', $item) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data pemanfaatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $utilizations->links() }}
            </div>
        </div>
    </div>
@stop
