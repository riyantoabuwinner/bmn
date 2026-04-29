@extends('adminlte::page')

@section('title', 'Laporan Evaluasi Aset')

@section('content_header')
    <h1>Laporan Hasil Evaluasi: {{ $evaluation->period_name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header no-print">
            <h3 class="card-title">Detail Laporan</h3>
            <div class="card-tools">
                <a href="{{ route('evaluations.print', $evaluation) }}" class="btn btn-danger btn-sm" target="_blank">
                    <i class="fas fa-file-pdf"></i> Cetak Laporan (PDF)
                </a>
                <a href="{{ route('evaluations.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row invoice-info mb-4">
                <div class="col-sm-4 invoice-col">
                    <strong>Informasi Periode</strong><br>
                    Tahun: {{ $evaluation->year }}<br>
                    Tipe: {{ ucfirst($evaluation->period_type) }}<br>
                    Semester: {{ $evaluation->semester ?? '-' }}
                </div>
                <div class="col-sm-4 invoice-col">
                    <strong>Status</strong><br>
                    Status: 
                    @if($evaluation->status == 'finalized')
                        <span class="badge badge-success">Final</span><br>
                        Tanggal Finalisasi: {{ $evaluation->finalized_at->format('d/m/Y') }}
                    @else
                        <span class="badge badge-warning">Draft</span>
                    @endif
                    <br>
                    Dibuat Oleh: {{ $evaluation->creator->name ?? '-' }}
                </div>
                <div class="col-sm-4 invoice-col">
                    <strong>Ringkasan Hasil</strong><br>
                    Total Aset: {{ $details->count() }}<br>
                    Baik: {{ $details->where('condition_status', 'baik')->count() }}<br>
                    Rusak (Ringan/Berat): {{ $details->whereIn('condition_status', ['rusak_ringan', 'rusak_berat'])->count() }}<br>
                    Hilang: {{ $details->where('condition_status', 'hilang')->count() }}
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Aset</th>
                        <th>Nama Aset</th>
                        <th>Kondisi</th>
                        <th>Tindakan Diperlukan</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($details as $detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $detail->asset->kode_barang ?? '-' }}</td>
                            <td>{{ $detail->asset->nama_barang ?? '-' }}</td>
                            <td>
                                @if($detail->condition_status == 'baik')
                                    <span class="badge badge-success">Baik</span>
                                @elseif($detail->condition_status == 'rusak_ringan')
                                    <span class="badge badge-warning">Rusak Ringan</span>
                                @elseif($detail->condition_status == 'rusak_berat')
                                    <span class="badge badge-danger">Rusak Berat</span>
                                @else
                                    <span class="badge badge-dark">Hilang</span>
                                @endif
                            </td>
                            <td>{{ $detail->action_needed ?? '-' }}</td>
                            <td>{{ $detail->notes ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="row mt-5">
                <div class="col-6"></div>
                <div class="col-6 text-center">
                    <p>Mengetahui,</p>
                    <br><br><br>
                    <p>(................................................)</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        @media print {
            .no-print { display: none !important; }
            .card { box-shadow: none !important; border: none !important; }
        }
    </style>
@stop
