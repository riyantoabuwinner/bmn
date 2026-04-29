@extends('adminlte::page')

@section('title', 'Detail Laporan Wasdal')

@section('content_header')
    <h1><i class="fas fa-clipboard-list"></i> Detail Laporan Wasdal</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Informasi Laporan</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Aset</th>
                            <td>{{ $report->asset->nama_barang ?? '-' }} ({{ $report->asset->kode_barang ?? '-' }})</td>
                        </tr>
                        <tr>
                            <th>Tahun / Periode</th>
                            <td>{{ $report->period_year }} - {{ $report->report_type }}</td>
                        </tr>
                        <tr>
                            <th>Status Kondisi</th>
                            <td>
                                @if($report->condition_status == 'Baik')
                                    <span class="badge badge-success">Baik</span>
                                @elseif($report->condition_status == 'Rusak Ringan')
                                    <span class="badge badge-warning">Rusak Ringan</span>
                                @else
                                    <span class="badge badge-danger">{{ $report->condition_status }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status Penggunaan</th>
                            <td>{{ $report->usage_status }}</td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $report->description ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Dokumen</th>
                            <td>
                                @if($report->document)
                                    <a href="{{ asset('storage/' . $report->document) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-download"></i> Lihat Dokumen
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada dokumen</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $report->created_at->format('d F Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('wasdal-reports.edit', $report->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('wasdal-reports.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <form action="{{ route('wasdal-reports.destroy', $report->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger float-right">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
