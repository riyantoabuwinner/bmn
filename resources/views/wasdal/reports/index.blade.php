@extends('adminlte::page')

@section('title', 'Pelaporan Wasdal')

@section('content_header')
    <h1>Pelaporan Wasdal BMN</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Laporan Wasdal</h3>
            <div class="card-tools">
                <a href="{{ route('wasdal-reports.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Buat Laporan Baru
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
                        <th>Tahun / Periode</th>
                        <th>Status Kondisi</th>
                        <th>Status Penggunaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $report->asset->nama_barang }} ({{ $report->asset->kode_barang }})</td>
                            <td>{{ $report->period_year }} - {{ $report->report_type }}</td>
                            <td>{{ $report->condition_status }}</td>
                            <td>{{ $report->usage_status }}</td>
                            <td>
                                <a href="{{ route('wasdal-reports.show', $report->id) }}" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('wasdal-reports.edit', $report->id) }}" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data pelaporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $reports->links() }}
        </div>
    </div>
@stop
