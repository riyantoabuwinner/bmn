@extends('adminlte::page')

@section('title', 'Detail Evaluasi Kinerja')

@section('content_header')
    <h1>Detail Evaluasi Kinerja Aset</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <i class="fas fa-chart-pie fa-3x text-primary mb-3"></i>
                    </div>
                    <h3 class="profile-username text-center">Status: {{ $performance->status }}</h3>
                    <p class="text-muted text-center">Efisiensi: {{ number_format($performance->efficiency_ratio, 2) }}%</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Target SBSK</b> <span class="float-right">{{ number_format($performance->sbsk_target, 2) }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Kondisi Eksisting</b> <span class="float-right">{{ number_format($performance->actual_usage, 2) }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Kategori</b> <span class="float-right">{{ $performance->category }}</span>
                        </li>
                    </ul>

                    <a href="{{ route('performances.edit', $performance) }}" class="btn btn-warning btn-block">
                        <i class="fas fa-edit"></i> Edit Eduasi
                    </a>
                    <a href="{{ route('performances.index') }}" class="btn btn-default btn-block">Kembali</a>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Aset & Rekomendasi</h3>
                </div>
                <div class="card-body">
                    <strong><i class="fas fa-box mr-1"></i> Aset Tertanggung</strong>
                    <p class="text-muted">
                        {{ $performance->asset->nama_barang }} <br>
                        Kode: {{ $performance->asset->kode_barang }} <br>
                        NUP: {{ $performance->asset->nup }} <br>
                        Lokasi: {{ $performance->asset->lokasi ?? '-' }}
                    </p>
                    <hr>

                    <strong><i class="fas fa-calendar-alt mr-1"></i> Tanggal Evaluasi</strong>
                    <p class="text-muted">
                        {{ $performance->evaluation_date->format('d F Y') }}
                    </p>
                    <hr>

                    <strong><i class="fas fa-lightbulb mr-1"></i> Rekomendasi / Tindak Lanjut</strong>
                    <div class="alert alert-light border mt-2">
                        {{ $performance->recommendation ?? 'Belum ada rekomendasi khusus.' }}
                    </div>
                    
                    <hr>
                    <small class="text-muted">Dievaluasi oleh: {{ $performance->creator->name ?? 'System' }}</small>
                </div>
            </div>
        </div>
    </div>
@stop
