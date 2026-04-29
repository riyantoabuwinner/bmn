@extends('adminlte::page')

@section('title', 'Detail Monitoring')

@section('content_header')
    <h1><i class="fas fa-search-location"></i> Detail Hasil Monitoring</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Informasi Monitoring</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Aset</th>
                            <td>{{ $monitoring->asset->nama_barang ?? '-' }} ({{ $monitoring->asset->kode_barang ?? '-' }})</td>
                        </tr>
                        <tr>
                            <th>Tanggal Inspeksi</th>
                            <td>{{ $monitoring->inspection_date->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Nama Inspektur</th>
                            <td>{{ $monitoring->inspector_name }}</td>
                        </tr>
                        <tr>
                            <th>Kesesuaian Penggunaan</th>
                            <td>
                                <span class="badge badge-{{ $monitoring->usage_conformity == 'Sesuai Peruntukan' ? 'success' : 'danger' }}">
                                    {{ $monitoring->usage_conformity }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Status Idle</th>
                            <td>
                                @if($monitoring->is_idle)
                                    <span class="badge badge-warning">Aset Terlantar (Idle)</span>
                                @else
                                    <span class="badge badge-primary">Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $monitoring->notes ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $monitoring->created_at->format('d F Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('wasdal-monitorings.edit', $monitoring->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('wasdal-monitorings.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <form action="{{ route('wasdal-monitorings.destroy', $monitoring->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
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
