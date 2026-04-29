@extends('adminlte::page')

@section('title', 'Detail Asuransi BMN')

@section('content_header')
    <h1>Detail Asuransi BMN</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                    </div>
                    <h3 class="profile-username text-center">Data Polis</h3>
                    <p class="text-muted text-center">{{ $insurance->policy_number ?? 'Belum ada nomor polis' }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Status</b> 
                            <span class="float-right badge {{ $insurance->status == 'Aktif' ? 'badge-success' : ($insurance->status == 'Usulan' ? 'badge-info' : 'badge-danger') }}">
                                {{ $insurance->status }}
                            </span>
                        </li>
                        <li class="list-group-item">
                            <b>Perusahaan</b> <span class="float-right">{{ $insurance->insurance_company ?? '-' }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Berlaku s/d</b> <span class="float-right">{{ $insurance->end_date ? $insurance->end_date->format('d/m/Y') : '-' }}</span>
                        </li>
                    </ul>

                    @if($insurance->document)
                        <a href="{{ asset('storage/' . $insurance->document) }}" target="_blank" class="btn btn-primary btn-block">
                            <i class="fas fa-file-pdf"></i> <b>Download Dokumen</b>
                        </a>
                    @endif
                    <a href="{{ route('insurances.index') }}" class="btn btn-default btn-block mt-2">Kembali</a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Detail Pertanggungan</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong><i class="fas fa-box mr-1"></i> Aset Tertanggung</strong>
                            <p class="text-muted">
                                {{ $insurance->asset->nama_barang }} <br>
                                <small>{{ $insurance->asset->kode_barang }} (NUP: {{ $insurance->asset->nup }})</small>
                            </p>
                            <hr>

                            <strong><i class="fas fa-calendar-alt mr-1"></i> Periode</strong>
                            <p class="text-muted">
                                Mulai: {{ $insurance->start_date ? $insurance->start_date->format('d M Y') : '-' }} <br>
                                Berakhir: {{ $insurance->end_date ? $insurance->end_date->format('d M Y') : '-' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <strong><i class="fas fa-money-bill-wave mr-1"></i> Nilai Keuangan</strong>
                            <p class="text-muted">
                                Nilai Pertanggungan: Rp {{ number_format($insurance->coverage_amount, 0, ',', '.') }} <br>
                                Premi: Rp {{ number_format($insurance->premium_amount, 0, ',', '.') }}
                            </p>
                            <hr>

                            <strong><i class="fas fa-user mr-1"></i> Dicatat Oleh</strong>
                            <p class="text-muted">
                                {{ $insurance->creator->name ?? 'System' }} <br>
                                <small>Pada: {{ $insurance->created_at->format('d/m/Y H:i') }}</small>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <strong><i class="fas fa-sticky-note mr-1"></i> Catatan</strong>
                    <p class="text-muted">{{ $insurance->notes ?? '-' }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('insurances.edit', $insurance) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Data
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop
