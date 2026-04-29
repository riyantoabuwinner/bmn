@extends('adminlte::page')

@section('title', 'Detail Pemanfaatan')

@section('content_header')
    <h1>Detail Pemanfaatan Aset</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nomor Kontrak: {{ $utilization->contract_number }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Aset</dt>
                        <dd class="col-sm-8">
                            {{ $utilization->asset->nama_barang }} ({{ $utilization->asset->kode_barang }})
                        </dd>

                        <dt class="col-sm-4">Jenis Pemanfaatan</dt>
                        <dd class="col-sm-8">{{ $utilization->utilization_type }}</dd>

                        <dt class="col-sm-4">Pihak Mitra</dt>
                        <dd class="col-sm-8">{{ $utilization->partner_name }}</dd>

                        <dt class="col-sm-4">Nilai (PNBP)</dt>
                        <dd class="col-sm-8">Rp {{ number_format($utilization->value, 0, ',', '.') }}</dd>

                         <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge badge-{{ $utilization->status == 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($utilization->status) }}
                            </span>
                        </dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">No. Perjanjian</dt>
                        <dd class="col-sm-8">{{ $utilization->contract_number }}</dd>

                        <dt class="col-sm-4">Tgl. Perjanjian</dt>
                        <dd class="col-sm-8">{{ $utilization->contract_date->format('d F Y') }}</dd>

                        <dt class="col-sm-4">Periode</dt>
                        <dd class="col-sm-8">
                            {{ $utilization->start_date->format('d M Y') }} s.d {{ $utilization->end_date->format('d M Y') }}
                        </dd>

                        <dt class="col-sm-4">Dokumen</dt>
                        <dd class="col-sm-8">
                            @if($utilization->document)
                                <a href="{{ asset('storage/' . $utilization->document) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file-pdf"></i> Lihat Dokumen
                                </a>
                            @else
                                <span class="text-muted">Tidak ada dokumen</span>
                            @endif
                        </dd>
                         <dt class="col-sm-4">Keterangan</dt>
                        <dd class="col-sm-8">{{ $utilization->description ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('utilizations.index') }}" class="btn btn-default">Kembali</a>
            <a href="{{ route('utilizations.edit', $utilization) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
@stop
