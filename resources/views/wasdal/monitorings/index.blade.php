@extends('adminlte::page')

@section('title', 'Monitoring & Idle')

@section('content_header')
    <h1>Monitoring Penggunaan BMN</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Hasil Monitoring</h3>
            <div class="card-tools">
                <a href="{{ route('wasdal-monitorings.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-search"></i> Rekam Monitoring Baru
                </a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Aset</th>
                        <th>Tgl Inspeksi</th>
                        <th>Inspektur</th>
                        <th>Kesesuaian</th>
                        <th>Status Idle</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($monitorings as $monitoring)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $monitoring->asset->nama_barang }}</td>
                            <td>{{ $monitoring->inspection_date->format('d-m-Y') }}</td>
                            <td>{{ $monitoring->inspector_name }}</td>
                            <td>
                                <span class="badge badge-{{ $monitoring->usage_conformity == 'Sesuai Peruntukan' ? 'success' : 'danger' }}">
                                    {{ $monitoring->usage_conformity }}
                                </span>
                            </td>
                            <td>
                                @if($monitoring->is_idle)
                                    <span class="badge badge-warning">Aset Terlantar (Idle)</span>
                                @else
                                    <span class="badge badge-primary">Aktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('wasdal-monitorings.show', $monitoring->id) }}" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data monitoring.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $monitorings->links() }}
        </div>
    </div>
@stop
