@extends('adminlte::page')

@section('title', 'Edit Aset Lancar')

@section('content_header')
    <h1>Edit Aset Lancar</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Edit Aset Lancar</h3>
        </div>
        <form action="{{ route('current-assets.update', $currentAsset) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <h5>Identitas Barang</h5>
                        <div class="form-group">
                            <label>Kode Barang <span class="text-danger">*</span></label>
                            <input type="text" name="kode_barang" class="form-control" required value="{{ old('kode_barang', $currentAsset->kode_barang) }}">
                        </div>
                        <div class="form-group">
                            <label>Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" name="nama_barang" class="form-control" required value="{{ old('nama_barang', $currentAsset->nama_barang) }}">
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <input type="text" name="kategori" class="form-control" value="{{ old('kategori', $currentAsset->kategori) }}">
                        </div>
                        <div class="form-group">
                            <label>Spesifikasi</label>
                            <textarea name="spesifikasi" class="form-control" rows="3">{{ old('spesifikasi', $currentAsset->spesifikasi) }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5>Stok & Nilai</h5>
                        <div class="alert alert-info">
                            <strong>Stok Saat Ini:</strong> {{ number_format($currentAsset->stok_tersedia) }} {{ $currentAsset->satuan }}<br>
                            <small>Gunakan tombol "Sesuaikan Stok" di halaman detail untuk menambah/mengurangi stok</small>
                        </div>
                        <div class="form-group">
                            <label>Satuan <span class="text-danger">*</span></label>
                            <input type="text" name="satuan" class="form-control" required value="{{ old('satuan', $currentAsset->satuan) }}">
                        </div>
                        <div class="form-group">
                            <label>Harga Satuan (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga_satuan" class="form-control" required min="0" value="{{ old('harga_satuan', $currentAsset->harga_satuan) }}">
                        </div>
                        <div class="form-group">
                            <label>Stok Minimum (Alert)</label>
                            <input type="number" name="stok_minimum" class="form-control" min="0" value="{{ old('stok_minimum', $currentAsset->stok_minimum) }}">
                        </div>
                    </div>

                    <div class="col-md-12"><hr></div>

                    <div class="col-md-6">
                        <h5>Perolehan</h5>
                        <div class="form-group">
                            <label>Tanggal Perolehan</label>
                            <input type="date" name="tanggal_perolehan" class="form-control" value="{{ old('tanggal_perolehan', $currentAsset->tanggal_perolehan ? $currentAsset->tanggal_perolehan->format('Y-m-d') : '') }}">
                        </div>
                        <div class="form-group">
                            <label>Sumber Dana</label>
                            <input type="text" name="sumber_dana" class="form-control" value="{{ old('sumber_dana', $currentAsset->sumber_dana) }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5>Lokasi & Lainnya</h5>
                        <div class="form-group">
                            <label>Lokasi Penyimpanan</label>
                            <input type="text" name="lokasi_penyimpanan" class="form-control" value="{{ old('lokasi_penyimpanan', $currentAsset->lokasi_penyimpanan) }}">
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $currentAsset->keterangan) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('current-assets.index') }}" class="btn btn-default">Kembali</a>
            </div>
        </form>
    </div>
@stop
