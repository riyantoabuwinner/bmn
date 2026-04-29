@extends('adminlte::page')

@section('title', 'Detail Pemindahtanganan')

@section('content_header')
    <h1>Detail Pemindahtanganan Aset</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informasi Pemindahtanganan</h3>
            <div class="card-tools">
                <a href="{{ route('transfers.edit', $transfer->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-pencil-alt"></i> Edit
                </a>
                <a href="{{ route('transfers.index') }}" class="btn btn-default btn-sm">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">Aset</th>
                            <td>{{ $transfer->asset->nama_barang }} ({{ $transfer->asset->kode_barang }})</td>
                        </tr>
                        <tr>
                            <th>NUP</th>
                            <td>{{ $transfer->asset->nup }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Pemindahtanganan</th>
                            <td>{{ $transfer->transfer_type }}</td>
                        </tr>
                        <tr>
                            <th>Pihak Penerima</th>
                            <td>{{ $transfer->recipient_name }}</td>
                        </tr>
                        <tr>
                            <th>Nilai Transaksi</th>
                            <td>Rp {{ number_format($transfer->value, 2, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">Nomor SK</th>
                            <td>{{ $transfer->sk_number }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal SK</th>
                            <td>{{ $transfer->sk_date->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Dokumen</th>
                            <td>
                                @if($transfer->document)
                                    <a href="{{ asset('storage/' . $transfer->document) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-download"></i> Unduh Dokumen
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $transfer->description ?? '-' }}</td>
                        </tr>
                         <tr>
                            <th>Dibuat Oleh</th>
                            <td>{{ $transfer->creator->name ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
