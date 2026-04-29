@extends('adminlte::page')

@section('title', 'Detail Penghapusan')

@section('content_header')
    <h1>Detail Penghapusan Aset</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informasi Penghapusan</h3>
            <div class="card-tools">
                <a href="{{ route('deletions.edit', $deletion->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-pencil-alt"></i> Edit
                </a>
                <a href="{{ route('deletions.index') }}" class="btn btn-default btn-sm">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">Aset</th>
                            <td>
                                {{ $deletion->asset ? $deletion->asset->nama_barang . ' (' . $deletion->asset->kode_barang . ')' : 'Aset (ID: '.$deletion->asset_id.')' }}
                            </td>
                        </tr>
                        <tr>
                            <th>NUP</th>
                            <td>{{ $deletion->asset ? $deletion->asset->nup : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Penghapusan</th>
                            <td>{{ $deletion->deletion_type }}</td>
                        </tr>
                        <tr>
                             <th>Nilai Buku</th>
                            <td>Rp {{ number_format($deletion->value, 2, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">Nomor SK</th>
                            <td>{{ $deletion->sk_number }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal SK</th>
                            <td>{{ $deletion->sk_date->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Dokumen SK</th>
                            <td>
                                @if($deletion->document)
                                    <a href="{{ asset('storage/' . $deletion->document) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-download"></i> Unduh Dokumen
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $deletion->description ?? '-' }}</td>
                        </tr>
                         <tr>
                            <th>Dibuat Oleh</th>
                            <td>{{ $deletion->creator->name ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle"></i> Aset yang dibatalkan penghapusannya akan kembali aktif di sistem.
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
