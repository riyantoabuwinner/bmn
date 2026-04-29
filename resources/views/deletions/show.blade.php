@extends('adminlte::page')

@section('title', 'Detail Penghapusan Aset')

@section('content_header')
    <h1>Detail Usulan Penghapusan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <!-- Asset Info -->
            <div class="card card-widget widget-user-2">
                <div class="widget-user-header bg-info">
                    <h3 class="widget-user-username">{{ $deletion->asset->nama_barang ?? '-' }}</h3>
                    <h5 class="widget-user-desc">{{ $deletion->asset->kode_barang ?? '-' }}</h5>
                </div>
                <div class="card-footer p-0">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <span class="nav-link">
                                Tipe Aset <span class="float-right badge bg-primary">{{ class_basename($deletion->asset_type) }}</span>
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link">
                                Kondisi <span class="float-right">{{ ucfirst($deletion->asset->condition_status ?? $deletion->asset->status ?? '-') }}</span>
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link">
                                Lokasi <span class="float-right">{{ $deletion->asset->location->name ?? '-' }}</span>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Penghapusan</h3>
                    <div class="card-tools">
                        <a href="{{ route('deletions.print', $deletion) }}" class="btn btn-default btn-sm" target="_blank">
                            <i class="fas fa-print"></i> Cetak Berita Acara
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Tanggal Usulan</dt>
                        <dd class="col-sm-8">{{ $deletion->proposal_date->format('d F Y') }}</dd>

                        <dt class="col-sm-4">Alasan</dt>
                        <dd class="col-sm-8">{{ $deletion->reason }}</dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            @if($deletion->status == 'pending')
                                <span class="badge badge-warning">Menunggu Persetujuan</span>
                            @elseif($deletion->status == 'approved')
                                <span class="badge badge-success">Disetujui</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </dd>

                        @if($deletion->document)
                            <dt class="col-sm-4">Dokumen Pendukung</dt>
                            <dd class="col-sm-8">
                                <a href="{{ asset('storage/' . $deletion->document) }}" target="_blank" class="btn btn-sm btn-default">
                                    <i class="fas fa-file"></i> Lihat Dokumen
                                </a>
                            </dd>
                        @endif
                    </dl>

                    @if($deletion->status != 'pending')
                         <div class="alert alert-light border">
                            <strong>{{ $deletion->status == 'approved' ? 'Disetujui' : 'Ditolak' }} oleh:</strong> 
                            {{ $deletion->approver->name ?? '-' }} pada {{ $deletion->approval_date->format('d/m/Y') }}
                         </div>
                    @endif
                </div>
                
                @if($deletion->status == 'pending' && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin')))
                    <div class="card-footer">
                        <form action="{{ route('deletions.approve', $deletion->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success" onclick="return confirm('Setujui penghapusan aset ini? Status aset akan diubah menjadi Dihapus.')">
                                <i class="fas fa-check"></i> Setujui
                            </button>
                        </form>
                        
                         <form action="{{ route('deletions.reject', $deletion->id) }}" method="POST" class="d-inline float-right">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak usulan penghapusan ini?')">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
