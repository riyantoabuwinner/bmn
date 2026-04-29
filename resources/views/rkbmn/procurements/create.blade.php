@extends('adminlte::page')

@section('title', 'Tambah Usulan Pengadaan')

@section('content_header')
    <h1>Rekam Usulan Pengadaan Baru</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('rkbmn.procurements.store') }}" method="POST">
            @csrf
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="year">Tahun Anggaran</label>
                            <input type="number" name="year" class="form-control" value="{{ date('Y') + 1 }}" min="2025" max="2030" required>
                        </div>

                        <div class="form-group">
                            <label for="name">Nama Barang</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Laptop Spesifikasi Tinggi" required>
                        </div>

                        <div class="form-group">
                            <label for="type">Jenis Aset</label>
                            <select name="type" class="form-control" required>
                                <option value="Tanah">Tanah</option>
                                <option value="Gedung dan Bangunan">Gedung dan Bangunan</option>
                                <option value="Peralatan dan Mesin">Peralatan dan Mesin</option>
                                <option value="Jalan, Irigasi, Jaringan">Jalan, Irigasi, Jaringan</option>
                                <option value="Aset Tetap Lainnya">Aset Tetap Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="quantity">Volume (Jumlah)</label>
                                    <input type="number" name="quantity" class="form-control" min="1" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="unit">Satuan</label>
                                    <input type="text" name="unit" class="form-control" placeholder="Unit/M2/Paket" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="estimated_unit_price">Estimasi Harga Satuan (Rp)</label>
                            <input type="number" name="estimated_unit_price" class="form-control" min="0" required>
                        </div>

                        <div class="form-group">
                            <label for="priority">Prioritas Kebutuhan</label>
                             <select name="priority" class="form-control" required>
                                <option value="Tinggi">Tinggi (Mendesak)</option>
                                <option value="Sedang">Sedang (Bisa Ditunda)</option>
                                <option value="Rendah">Rendah (Pelengkap)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="justification">Justifikasi Kebutuhan (Alasan Pengadaan)</label>
                    <textarea name="justification" class="form-control" rows="3" required></textarea>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Usulan</button>
                <a href="{{ route('rkbmn.procurements.index') }}" class="btn btn-default">Kembali</a>
            </div>
        </form>
    </div>
@stop
