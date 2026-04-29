@extends('adminlte::page')

@section('title', 'Detail Usulan Pengadaan')

@section('content_header')
    <h1>Detail Usulan Pengadaan</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $procurement->name }} ({{ $procurement->year }})</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Tahun Anggaran</dt>
                        <dd class="col-sm-8">{{ $procurement->year }}</dd>

                        <dt class="col-sm-4">Jenis Aset</dt>
                        <dd class="col-sm-8">{{ $procurement->type }}</dd>

                        <dt class="col-sm-4">Volume</dt>
                        <dd class="col-sm-8">{{ $procurement->quantity }} {{ $procurement->unit }}</dd>

                        <dt class="col-sm-4">Prioritas</dt>
                        <dd class="col-sm-8">
                             <span class="badge badge-{{ $procurement->priority == 'Tinggi' ? 'danger' : ($procurement->priority == 'Sedang' ? 'warning' : 'success') }}">
                                {{ $procurement->priority }}
                            </span>
                        </dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Harga Satuan</dt>
                        <dd class="col-sm-8">Rp {{ number_format($procurement->estimated_unit_price, 0, ',', '.') }}</dd>

                        <dt class="col-sm-4">Total Biaya</dt>
                        <dd class="col-sm-8"><strong>Rp {{ number_format($procurement->total_price, 0, ',', '.') }}</strong></dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">{{ ucfirst($procurement->status) }}</dd>

                         <dt class="col-sm-4">Dibuat Oleh</dt>
                        <dd class="col-sm-8">{{ $procurement->creator->name ?? 'System' }}</dd>
                    </dl>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5>Justifikasi</h5>
                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                        {{ $procurement->justification }}
                    </p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('rkbmn.procurements.index') }}" class="btn btn-default">Kembali</a>
            <a href="{{ route('rkbmn.procurements.edit', $procurement) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
@stop
