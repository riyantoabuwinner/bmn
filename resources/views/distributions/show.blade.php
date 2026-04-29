@extends('adminlte::page')

@section('title', 'Detail Distribusi')

@section('content_header')
    <h1>Detail Distribusi Aset</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informasi Distribusi</h3>
            <div class="card-tools">
                <a href="{{ route('distributions.print', $distribution) }}" class="btn btn-danger btn-sm" target="_blank">
                    <i class="fas fa-file-pdf"></i> Cetak BAST
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px">Asset</th>
                    <td>{{ $distribution->asset->nama_barang }} ({{ $distribution->asset->kode_barang }})</td>
                </tr>
                <tr>
                    <th>Unit Tujuan</th>
                    <td>{{ $distribution->unit->name }}</td>
                </tr>
                <tr>
                    <th>Penerima</th>
                    <td>{{ $distribution->recipient_name }}</td>
                </tr>
                <tr>
                    <th>Jabatan Penerima</th>
                    <td>{{ $distribution->recipient_position }}</td>
                </tr>
                <tr>
                    <th>Tanggal Distribusi</th>
                    <td>{{ \Carbon\Carbon::parse($distribution->distribution_date)->format('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Catatan</th>
                    <td>{{ $distribution->notes ?? '-' }}</td>
                </tr>
            </table>

            <div class="mt-4">
                <a href="{{ route('distributions.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@stop
