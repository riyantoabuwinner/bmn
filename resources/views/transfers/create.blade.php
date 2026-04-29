@extends('adminlte::page')

@section('title', 'Rekam Pemindahtanganan')

@section('content_header')
    <h1>Rekam Pemindahtanganan Aset</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('transfers.store') }}" method="POST" enctype="multipart/form-data">
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
                            <label for="asset_id">Pilih Aset</label>
                            <select name="asset_id" id="asset_id" class="form-control select2" required>
                                <option value="">-- Pilih Aset --</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="transfer_type">Jenis Pemindahtanganan</label>
                            <select name="transfer_type" id="transfer_type" class="form-control" required>
                                <option value="Penjualan">Penjualan</option>
                                <option value="Hibah">Hibah</option>
                                <option value="Tukar Menukar">Tukar Menukar</option>
                                <option value="PMP">Penyertaan Modal Pemerintah (PMP)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="recipient_name">Pihak Penerima</label>
                            <input type="text" name="recipient_name" class="form-control" required placeholder="Nama Instansi / Pihak Ketiga">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sk_number">Nomor SK/Dokumen</label>
                            <input type="text" name="sk_number" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="sk_date">Tanggal SK</label>
                            <input type="date" name="sk_date" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="value">Nilai Transaksi (Jika Ada) - Rp</label>
                            <input type="number" name="value" class="form-control" value="0" min="0">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="document">Upload Dokumen (SK/BAST/dst)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="document" class="custom-file-input" id="document">
                                    <label class="custom-file-label" for="document">Pilih file</label>
                                </div>
                            </div>
                            <small class="text-muted">Max 2MB (PDF/JPG/PNG)</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">Keterangan Lain</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('transfers.index') }}" class="btn btn-default">Kembali</a>
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
             $('.select2').select2({
                ajax: {
                    url: "{{ route('assets.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                placeholder: 'Cari Aset (Nama/Kode/NUP)...',
                minimumInputLength: 1
            });
            
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        });
    </script>
@stop
