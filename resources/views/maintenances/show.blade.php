@extends('adminlte::page')

@section('title', 'Detail Maintenance')

@section('content_header')
    <h1>Detail Maintenance</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informasi Maintenance</h3>
            <div class="card-tools">
                <a href="{{ route('maintenances.print', $maintenance) }}" class="btn btn-default btn-sm" target="_blank">
                    <i class="fas fa-print"></i> Cetak Laporan
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px">Aset</th>
                    <td>{{ $maintenance->asset->nama_barang }} ({{ $maintenance->asset->kode_barang }})</td>
                </tr>
                <tr>
                    <th>Tipe</th>
                    <td>{{ ucfirst($maintenance->maintenance_type) }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst(str_replace('_', ' ', $maintenance->status)) }}</td>
                </tr>
                <tr>
                    <th>Kondisi Awal</th>
                    <td>{{ ucfirst(str_replace('_', ' ', $maintenance->condition_before)) }}</td>
                </tr>
                <tr>
                    <th>Kondisi Akhir</th>
                    <td>{{ $maintenance->condition_after ? ucfirst(str_replace('_', ' ', $maintenance->condition_after)) : '-' }}</td>
                </tr>
                <tr>
                    <th>Biaya Estimasi</th>
                    <td>Rp {{ number_format($maintenance->estimated_cost, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Biaya Aktual</th>
                    <td>Rp {{ number_format($maintenance->actual_cost, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $maintenance->description }}</td>
                </tr>
                <tr>
                    <th>Catatan Penyelesaian</th>
                    <td>{{ $maintenance->completion_notes ?? '-' }}</td>
                </tr>
            </table>

            <div class="mt-4">
                <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@stop
