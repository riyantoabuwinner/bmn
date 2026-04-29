@extends('adminlte::page')

@section('title', 'Detail Usulan Aksi')

@section('content_header')
    <h1>Detail Usulan Pemanfaatan/Pemindahtanganan</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Usulan Tahun {{ $action->year }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Aset</dt>
                        <dd class="col-sm-8">
                            {{ $action->asset->nama_barang }} ({{ $action->asset->kode_barang }})
                        </dd>

                        <dt class="col-sm-4">Jenis Aksi</dt>
                        <dd class="col-sm-8">{{ $action->action_type }}</dd>

                        <dt class="col-sm-4">Estimasi PNBP</dt>
                        <dd class="col-sm-8"><strong>Rp {{ number_format($action->estimated_revenue, 0, ',', '.') }}</strong></dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">{{ ucfirst($action->status) }}</dd>

                         <dt class="col-sm-4">Dibuat Oleh</dt>
                        <dd class="col-sm-8">{{ $action->creator->name ?? 'System' }}</dd>
                    </dl>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5>Justifikasi</h5>
                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                        {{ $action->justification }}
                    </p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('rkbmn.actions.index') }}" class="btn btn-default">Kembali</a>
            <a href="{{ route('rkbmn.actions.edit', $action) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
@stop
