@extends('adminlte::page')

@section('title', 'Buat Transaksi Persediaan')

@section('content_header')
    <h1>Buat Transaksi Persediaan Baru</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('current-asset-transactions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jenis Transaksi</label>
                            <select name="transaction_type" class="form-control" id="typeSelect" required>
                                <option value="">-- Pilih Jenis --</option>
                                <optgroup label="Masuk (Menambah Stok)">
                                    <option value="purchase">Pembelian</option>
                                    <option value="transfer_in">Transfer Masuk</option>
                                    <option value="grant_in">Hibah Masuk</option>
                                    <option value="production">Hasil Produksi Sendiri</option>
                                </optgroup>
                                <optgroup label="Keluar (Mengurangi Stok)">
                                    <option value="usage">Pemakaian (Operasional)</option>
                                    <option value="transfer_out">Transfer Keluar</option>
                                    <option value="grant_out">Hibah Keluar</option>
                                    <option value="disposal">Penghapusan (Usang/Rusak)</option>
                                </optgroup>
                                <optgroup label="Penyesuaian">
                                    <option value="opname">Stock Opname</option>
                                    <option value="correction">Koreksi</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Pilih Barang Persediaan</label>
                            <select name="current_asset_id" class="form-control select2" required>
                                <option value="">-- Pilih Aset --</option>
                                @foreach($assets as $asset)
                                    <option value="{{ $asset->id }}">
                                        {{ $asset->kode_barang }} - {{ $asset->nama_barang }} (Stok: {{ $asset->stok_tersedia }} {{ $asset->satuan }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nomor Dokumen / Referensi</label>
                            <input type="text" name="reference_number" class="form-control" placeholder="No. BAST / Faktur / Surat Jalan" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Transaksi</label>
                            <input type="date" name="transaction_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jumlah (Kuantitas)</label>
                            <input type="number" name="quantity" class="form-control" min="1" required>
                        </div>

                        <div class="form-group">
                            <label>Harga Satuan (Opsional)</label>
                            <input type="number" name="unit_price" class="form-control" placeholder="Biarkan kosong untuk menggunakan harga master">
                            <small class="text-muted">Wajib diisi untuk Pembelian baru dengan harga berbeda.</small>
                        </div>

                        <div class="form-group">
                            <label>Bukti Dokumen (PDF/Gambar)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="proof_document" class="custom-file-input" id="proofDoc">
                                    <label class="custom-file-label" for="proofDoc">Pilih file</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('current-asset-transactions.index') }}" class="btn btn-default">Batal</a>
                <button type="submit" class="btn btn-primary float-right">Simpan (Draft)</button>
            </div>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        });
    </script>
@stop
