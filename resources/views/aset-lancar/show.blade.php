@extends('adminlte::page')

@section('title', 'Detail Aset Lancar')

@section('content_header')
    <h1>Detail Aset Lancar</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $asetLancar->name }}</h3>
            <div class="card-tools">
                <a href="{{ route('aset-lancar.edit', $asetLancar) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Kode Aset</th>
                            <td><strong>{{ $asetLancar->asset_code }}</strong></td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $asetLancar->name }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $asetLancar->category->name }}</td>
                        </tr>
                        <tr>
                            <th>Unit Pemilik</th>
                            <td>{{ $asetLancar->unit->name }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $asetLancar->location->name }}</td>
                        </tr>
                        <tr>
                            <th>Stok Saat Ini</th>
                            <td>
                                <strong class="{{ $asetLancar->isLowStock() ? 'text-danger' : 'text-success' }}">
                                    {{ number_format($asetLancar->quantity) }} {{ $asetLancar->unit_of_measure }}
                                </strong>
                                @if($asetLancar->isLowStock())
                                    <span class="badge badge-warning ml-2">Stok Menipis!</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Batas Reorder</th>
                            <td>{{ number_format($asetLancar->reorder_level) }} {{ $asetLancar->unit_of_measure }}</td>
                        </tr>
                        <tr>
                            <th>Harga Satuan</th>
                            <td>Rp {{ number_format($asetLancar->unit_price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Nilai Total</th>
                            <td><strong>Rp {{ number_format($asetLancar->total_value, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <th>Tanggal Pembelian</th>
                            <td>{{ $asetLancar->purchase_date->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Kadaluarsa</th>
                            <td>
                                @if($asetLancar->expiry_date)
                                    {{ $asetLancar->expiry_date->format('d/m/Y') }}
                                    @if($asetLancar->isExpired())
                                        <span class="badge badge-danger ml-2">Kadaluarsa!</span>
                                    @endif
                                @else
                                    <em class="text-muted">Tidak ada</em>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Kondisi</th>
                            <td>
                                @if($asetLancar->condition_status == 'baik')
                                    <span class="badge badge-success">Baik</span>
                                @else
                                    <span class="badge badge-danger">Rusak</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $asetLancar->notes ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4 text-center">
                    @if($asetLancar->photo)
                        <img src="{{ asset('storage/' . $asetLancar->photo) }}" class="img-fluid mb-3" alt="{{ $asetLancar->name }}">
                    @else
                        <p class="text-muted"><em>Tidak ada foto</em></p>
                    @endif
                    @if($asetLancar->qr_code)
                        <div class="mt-3">
                            <h5>QR Code</h5>
                            {!! QrCode::size(150)->generate($asetLancar->qr_code) !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('aset-lancar.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('aset-lancar.edit', $asetLancar) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('aset-lancar.destroy', $asetLancar) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
@stop
