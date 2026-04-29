@extends('adminlte::page')

@section('title', 'Detail PSP')

@section('content_header')
    <h1>Detail Penetapan Status Penggunaan</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nomor SK: {{ $psp->sk_number }}</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Aset</dt>
                <dd class="col-sm-9">
                    {{ $psp->asset->nama_barang }} ({{ $psp->asset->kode_barang }})
                    <br>
                    <small class="text-muted">NUP: {{ $psp->asset->nup }}</small>
                </dd>

                <dt class="col-sm-3">Tanggal SK</dt>
                <dd class="col-sm-9">{{ $psp->sk_date->format('d F Y') }}</dd>

                <dt class="col-sm-3">Status Dokumen</dt>
                <dd class="col-sm-9">
                     <span class="badge badge-{{ $psp->status == 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($psp->status) }}
                    </span>
                </dd>

                <dt class="col-sm-3">Dokumen Fisik</dt>
                <dd class="col-sm-9">
                    @if($psp->document)
                        <a href="{{ asset('storage/' . $psp->document) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-file-pdf"></i> Lihat Dokumen
                        </a>
                    @else
                        <span class="text-muted">Tidak ada dokumen diunggah</span>
                    @endif
                </dd>

                <dt class="col-sm-3">Catatan</dt>
                <dd class="col-sm-9">{{ $psp->notes ?? '-' }}</dd>

                <dt class="col-sm-3">Direkam Oleh</dt>
                <dd class="col-sm-9">{{ $psp->creator->name ?? 'System' }}</dd>

                <dt class="col-sm-3">Direkam Pada</dt>
                <dd class="col-sm-9">{{ $psp->created_at->format('d M Y H:i') }}</dd>
            </dl>
        </div>
        <div class="card-footer">
            <a href="{{ route('psp.index') }}" class="btn btn-default">Kembali</a>
            <a href="{{ route('psp.edit', $psp) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
@stop
