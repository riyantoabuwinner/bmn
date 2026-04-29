@extends('adminlte::page')

@section('title', 'Detail Aset Lancar')

@section('content_header')
    <h1>Detail Aset Lancar</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <h3 class="profile-username text-center">{{ $currentAsset->nama_barang }}</h3>
                    <p class="text-muted text-center">{{ $currentAsset->kode_barang }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Kategori</b> <a class="float-right">{{ $currentAsset->kategori ?? '-' }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Stok Tersedia</b> 
                            <a class="float-right">
                                <strong>{{ number_format($currentAsset->stok_tersedia) }}</strong> {{ $currentAsset->satuan }}
                                @if($currentAsset->is_low_stock)
                                    <br><span class="badge badge-warning">Stok Rendah!</span>
                                @endif
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Nilai Total</b> <a class="float-right">Rp {{ number_format($currentAsset->nilai_total, 0, ',', '.') }}</a>
                        </li>
                    </ul>

                    <a href="{{ route('current-assets.index') }}" class="btn btn-default btn-block"><b>Kembali</b></a>
                    <a href="{{ route('current-assets.edit', $currentAsset) }}" class="btn btn-primary btn-block"><b>Edit</b></a>
                    <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#stockModal"><b>Sesuaikan Stok</b></button>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Detail</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong><i class="fas fa-boxes mr-1"></i> Stok</strong>
                            <p class="text-muted">
                                Stok Awal: {{ number_format($currentAsset->stok_awal) }}<br>
                                Stok Masuk: {{ number_format($currentAsset->stok_masuk) }}<br>
                                Stok Keluar: {{ number_format($currentAsset->stok_keluar) }}<br>
                                <strong>Stok Tersedia: {{ number_format($currentAsset->stok_tersedia) }}</strong><br>
                                Stok Minimum: {{ number_format($currentAsset->stok_minimum) }}
                            </p>

                            <strong><i class="fas fa-money-bill-wave mr-1"></i> Nilai</strong>
                            <p class="text-muted">
                                Harga Satuan: Rp {{ number_format($currentAsset->harga_satuan, 0, ',', '.') }}<br>
                                <strong>Nilai Total: Rp {{ number_format($currentAsset->nilai_total, 0, ',', '.') }}</strong>
                            </p>
                        </div>

                        <div class="col-md-6">
                            <strong><i class="far fa-calendar-alt mr-1"></i> Perolehan</strong>
                            <p class="text-muted">
                                Tanggal: {{ $currentAsset->tanggal_perolehan ? $currentAsset->tanggal_perolehan->format('d M Y') : '-' }}<br>
                                Sumber Dana: {{ $currentAsset->sumber_dana ?? '-' }}
                            </p>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Lokasi</strong>
                            <p class="text-muted">{{ $currentAsset->lokasi_penyimpanan ?? '-' }}</p>

                            <strong><i class="fas fa-info-circle mr-1"></i> Spesifikasi</strong>
                            <p class="text-muted">{{ $currentAsset->spesifikasi ?? '-' }}</p>
                        </div>
                    </div>

                    <hr>
                    <strong>Keterangan</strong>
                    <p class="text-muted">{{ $currentAsset->keterangan ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Adjustment Modal -->
    <div class="modal fade" id="stockModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('current-assets.adjust-stock', $currentAsset->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Sesuaikan Stok</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Jenis Penyesuaian</label>
                            <select name="type" class="form-control" required>
                                <option value="in">Stok Masuk (+)</option>
                                <option value="out">Stok Keluar (-)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" name="quantity" class="form-control" required min="1">
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Pembelian, Pemakaian, dll"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
