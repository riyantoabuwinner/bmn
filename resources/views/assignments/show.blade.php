@extends('adminlte::page')

@section('title', 'Detail BAST')

@section('content_header')
    <h1>Detail Berita Acara Serah Terima</h1>
@stop

@section('content')
    <div class="row no-print">
        <div class="col-12 mb-3">
            <a href="{{ route('assignments.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            <a href="{{ route('assignments.print', $assignment) }}" class="btn btn-danger float-right ml-2" target="_blank"><i class="fas fa-file-pdf"></i> Cetak BAST (PDF)</a>
            <button onclick="window.print()" class="btn btn-primary float-right"><i class="fas fa-print"></i> Cetak Label</button>
            @if($assignment->status == 'active')
                <a href="{{ route('assignments.return', $assignment) }}" class="btn btn-warning float-right mr-2">
                    <i class="fas fa-undo"></i> Proses Pengembalian
                </a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-body p-4" id="bast-area">
            <!-- Kop Surat -->
            <div class="text-center mb-5">
                <h3 class="font-weight-bold">BERITA ACARA SERAH TERIMA BARANG MILIK NEGARA</h3>
                <h5>Nomor: BAST/{{ $assignment->created_at->format('Y') }}/{{ str_pad($assignment->id, 4, '0', STR_PAD_LEFT) }}</h5>
            </div>

            <p>Pada hari ini, <strong>{{ \Carbon\Carbon::parse($assignment->assigned_date)->isoFormat('dddd') }}</strong> tanggal <strong>{{ \Carbon\Carbon::parse($assignment->assigned_date)->isoFormat('D MMMM Y') }}</strong>, kami yang bertanda tangan di bawah ini:</p>

            <table class="table table-borderless table-sm offset-md-1 col-md-10">
                <tr>
                    <td width="5%">1.</td>
                    <td width="20%">Nama</td>
                    <td width="2%">:</td>
                    <td><strong>{{ auth()->user()->name }}</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>{{ auth()->user()->role ?? 'Petugas BMN' }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="pl-4 font-italic">Selanjutnya disebut <strong>PIHAK PERTAMA</strong> (Yang Menyerahkan)</td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Nama</td>
                    <td>:</td>
                    <td><strong>{{ $assignment->employee_name }}</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td>NIP / ID</td>
                    <td>:</td>
                    <td>{{ $assignment->employee_id_number ?? '-' }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>{{ $assignment->position ?? '-' }}</td>
                </tr>
                 <tr>
                    <td></td>
                    <td>Unit/Divisi</td>
                    <td>:</td>
                    <td>{{ $assignment->department ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="pl-4 font-italic">Selanjutnya disebut <strong>PIHAK KEDUA</strong> (Yang Menerima)</td>
                </tr>
            </table>

            <p class="mt-3">PIHAK PERTAMA menyerahkan kepada PIHAK KEDUA, dan PIHAK KEDUA menerima dari PIHAK PERTAMA barang dengan rincian sebagai berikut:</p>

            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Aset</th>
                        <th>Nama Barang</th>
                        <th>Merk / Tipe</th>
                        <th>Tahun</th>
                        <th>Kondisi</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $assignment->asset->kode_barang }}</td>
                        <td>{{ $assignment->asset->nama_barang }}</td>
                        <td>{{ $assignment->asset->merk_type ?? '-' }}</td>
                        <td>{{ $assignment->asset->tgl_perolehan ? $assignment->asset->tgl_perolehan->format('Y') : '-' }}</td>
                        <td>{{ ucfirst($assignment->condition_on_assign) }}</td>
                        <td>{{ $assignment->asset->nup ? 'NUP: ' . $assignment->asset->nup : '-' }}</td>
                    </tr>
                </tbody>
            </table>

            @if($assignment->asset->qr_code)
                <div class="text-center my-3">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode($assignment->asset->qr_code) }}" alt="QR Code">
                    <br><small>{{ $assignment->asset->kode_barang }}</small>
                </div>
            @endif

            <p class="mt-3">
                <strong>Catatan:</strong> {{ $assignment->notes ?? '-' }}
            </p>

            <p>Demikian Berita Acara Serah Terima ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>

            <br><br>
            <div class="row text-center mt-5">
                <div class="col-md-6">
                    <p>PIHAK KEDUA</p>
                    <br><br><br>
                    <p><strong>( {{ $assignment->employee_name }} )</strong></p>
                    <p>NIP. {{ $assignment->employee_id_number ?? '....................' }}</p>
                </div>
                <div class="col-md-6">
                    <p>PIHAK PERTAMA</p>
                    <br><br><br>
                    <p><strong>( {{ auth()->user()->name }} )</strong></p>
                    <p>NIP. ....................</p>
                </div>
            </div>
             <br><br>
            <div class="row text-center">
                 <div class="col-md-12">
                    <p>Mengetahui,</p>
                    <p>Kepala Bagian Umum / BMN</p>
                    <br><br><br>
                    <p><strong>( ........................................... )</strong></p>
                    <p>NIP. ....................</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        @media print {
            .no-print, .main-header, .main-sidebar, .content-header, .card-header, .card-footer {
                display: none !important;
            }
            .content-wrapper, .card {
                background: white !important;
                border: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .card-body {
                padding: 0 !important;
            }
        }
    </style>
@stop
