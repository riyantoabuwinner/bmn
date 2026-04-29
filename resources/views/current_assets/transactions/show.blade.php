@extends('adminlte::page')

@section('title', 'Detail Transaksi')

@section('content_header')
    <h1>Detail Transaksi #{{ $transaction->id }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Transaksi</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Jenis Transaksi</dt>
                        <dd class="col-sm-8">{{ ucfirst($transaction->transaction_type) }}</dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge badge-{{ $transaction->status == 'approved' ? 'success' : ($transaction->status == 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </dd>

                        <dt class="col-sm-4">Tanggal</dt>
                        <dd class="col-sm-8">{{ $transaction->transaction_date->format('d M Y') }}</dd>

                        <dt class="col-sm-4">No. Referensi</dt>
                        <dd class="col-sm-8">{{ $transaction->reference_number }}</dd>

                        <dt class="col-sm-4">Barang Persediaan</dt>
                        <dd class="col-sm-8">
                            {{ $transaction->currentAsset->nama_barang }} <br>
                            <small class="text-muted">{{ $transaction->currentAsset->kode_barang }}</small>
                        </dd>

                        <dt class="col-sm-4">Jumlah</dt>
                        <dd class="col-sm-8 font-weight-bold">{{ $transaction->quantity }} {{ $transaction->currentAsset->satuan }}</dd>

                        <dt class="col-sm-4">Harga Satuan</dt>
                        <dd class="col-sm-8">Rp {{ number_format($transaction->unit_price, 0, ',', '.') }}</dd>

                        <dt class="col-sm-4">Total Nilai</dt>
                        <dd class="col-sm-8">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</dd>

                        <dt class="col-sm-4">Keterangan</dt>
                        <dd class="col-sm-8">{{ $transaction->description ?? '-' }}</dd>

                        <dt class="col-sm-4">Dibuat Oleh</dt>
                        <dd class="col-sm-8">{{ $transaction->creator->name }}</dd>
                    </dl>

                    @if($transaction->proof_document)
                        <hr>
                        <strong>Bukti Dokumen:</strong> <br>
                        <a href="{{ asset('storage/' . $transaction->proof_document) }}" target="_blank" class="btn btn-sm btn-default mt-2">
                            <i class="fas fa-file-pdf"></i> Lihat Dokumen
                        </a>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('current-asset-transactions.index') }}" class="btn btn-default">Kembali</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if($transaction->status == 'pending')
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Persetujuan (Validasi)</h3>
                    </div>
                    <div class="card-body">
                        <p>Transaksi ini masih berstatus <strong>Pending</strong>. Apakah Anda ingin menyetujui transaksi ini?</p>
                        <p class="small text-muted">Penyetujuan akan langsung memperbarui stok master barang.</p>
                        
                        <form action="{{ route('current-asset-transactions.action', $transaction) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="approve">
                            <button type="submit" class="btn btn-success btn-block mb-3" onclick="return confirm('Yakin setujui transaksi ini?')">
                                <i class="fas fa-check"></i> Setujui (Approve)
                            </button>
                        </form>

                        <form action="{{ route('current-asset-transactions.action', $transaction) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Yakin tolak transaksi ini?')">
                                <i class="fas fa-times"></i> Tolak (Reject)
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($transaction->status == 'approved')
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Disetujui</h3>
                    </div>
                    <div class="card-body">
                        <p>Transaksi ini telah disetujui oleh <strong>{{ $transaction->approver->name ?? '-' }}</strong> pada {{ $transaction->approved_at->format('d M Y H:i') }}.</p>
                    </div>
                </div>
            @else
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Ditolak</h3>
                    </div>
                    <div class="card-body">
                        <p>Transaksi ini telah ditolak oleh <strong>{{ $transaction->approver->name ?? '-' }}</strong> pada {{ $transaction->approved_at->format('d M Y H:i') }}.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop
