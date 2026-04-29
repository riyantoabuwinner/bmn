@extends('adminlte::page')

@section('title', 'Detail Usulan Penghapusan')

@section('content_header')
    <h1>Detail Usulan Penghapusan</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Usulan Tahun {{ $deletion->year }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Aset</dt>
                        <dd class="col-sm-8">
                            {{ $deletion->asset->nama_barang }} ({{ $deletion->asset->kode_barang }})
                        </dd>

                        <dt class="col-sm-4">Alasan</dt>
                        <dd class="col-sm-8">{{ $deletion->deletion_type }}</dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                             <span class="badge badge-secondary">{{ ucfirst($deletion->status) }}</span>
                        </dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl class="row">
                         <dt class="col-sm-4">Dibuat Oleh</dt>
                        <dd class="col-sm-8">{{ $deletion->creator->name ?? 'System' }}</dd>

                        <dt class="col-sm-4">Dibuat Pada</dt>
                        <dd class="col-sm-8">{{ $deletion->created_at->format('d M Y') }}</dd>
                    </dl>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5>Justifikasi</h5>
                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                        {{ $deletion->justification }}
                    </p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('rkbmn.deletions.index') }}" class="btn btn-default">Kembali</a>
            <a href="{{ route('rkbmn.deletions.edit', $deletion) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
@stop
