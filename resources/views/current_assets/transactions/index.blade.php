@extends('adminlte::page')

@section('title', 'Transaksi Persediaan')

@section('content_header')
    <h1>Transaksi Persediaan (SAKTI)</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Transaksi</h3>
            <div class="card-tools">
                <a href="{{ route('current-asset-transactions.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Transaksi Baru
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="transactionsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Dokumen</th>
                        <th>Aset</th>
                        <th>Jenis Transaksi</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                            <td>{{ $transaction->reference_number }}</td>
                            <td>
                                <strong>{{ $transaction->currentAsset->kode_barang }}</strong><br>
                                {{ $transaction->currentAsset->nama_barang }}
                            </td>
                            <td>
                                @php
                                    $badges = [
                                        'purchase' => 'primary', 'transfer_in' => 'info', 'grant_in' => 'success', 'production' => 'secondary',
                                        'usage' => 'warning', 'transfer_out' => 'danger', 'grant_out' => 'danger', 'disposal' => 'dark',
                                        'correction' => 'secondary', 'opname' => 'purple'
                                    ];
                                    $labels = [
                                        'purchase' => 'Pembelian', 'transfer_in' => 'Transfer Masuk', 'grant_in' => 'Hibah Masuk',
                                        'usage' => 'Pemakaian', 'transfer_out' => 'Transfer Keluar', 'disposal' => 'Penghapusan',
                                        'opname' => 'Stock Opname'
                                    ];
                                @endphp
                                <span class="badge badge-{{ $badges[$transaction->transaction_type] ?? 'secondary' }}">
                                    {{ $labels[$transaction->transaction_type] ?? ucfirst($transaction->transaction_type) }}
                                </span>
                            </td>
                            <td>
                                @if(in_array($transaction->transaction_type, ['usage', 'transfer_out', 'grant_out', 'disposal']))
                                    <span class="text-danger">-{{ $transaction->quantity }}</span>
                                @else
                                    <span class="text-success">+{{ $transaction->quantity }}</span>
                                @endif
                                <small>{{ $transaction->currentAsset->satuan }}</small>
                            </td>
                            <td>
                                @if($transaction->status == 'approved')
                                    <span class="badge badge-success">Disetujui</span>
                                @elseif($transaction->status == 'rejected')
                                    <span class="badge badge-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-warning">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('current-asset-transactions.show', $transaction) }}" class="btn btn-info btn-xs">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="mt-3">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
@stop
