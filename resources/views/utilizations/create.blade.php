@extends('adminlte::page')

@section('title', 'Rekam Pemanfaatan')

@section('content_header')
    <h1>Rekam Pemanfaatan Aset Baru</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('utilizations.store') }}" method="POST" enctype="multipart/form-data">
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
                            <label for="utilization_type">Bentuk Pemanfaatan</label>
                            <select name="utilization_type" id="utilization_type" class="form-control" required>
                                <option value="Sewa">Sewa</option>
                                <option value="Pinjam Pakai">Pinjam Pakai</option>
                                <option value="KSP">Kerjasama Pemanfaatan (KSP)</option>
                                <option value="BGS">Bangun Guna Serah (BGS)</option>
                                <option value="BSG">Bangun Serah Guna (BSG)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="partner_name">Pihak Ketiga (Mitra)</label>
                            <input type="text" name="partner_name" class="form-control" required placeholder="Nama Perusahaan / Instansi / Perorangan">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contract_number">Nomor Perjanjian/Kontrak</label>
                            <input type="text" name="contract_number" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="contract_date">Tanggal Perjanjian</label>
                            <input type="date" name="contract_date" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="start_date">Mulai</label>
                                    <input type="date" name="start_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="end_date">Berakhir</label>
                                    <input type="date" name="end_date" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                         <div class="form-group">
                            <label for="value">Nilai Pemanfaatan (PNBP) - Rp</label>
                            <input type="number" name="value" class="form-control" value="0" min="0">
                            <small class="text-muted">Isi 0 jika tidak ada nilai komersial (misal: Pinjam Pakai)</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="document">Upload Dokumen Perjanjian</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="document" class="custom-file-input" id="document">
                                    <label class="custom-file-label" for="document">Pilih file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Keterangan Lain</label>
                    <textarea name="description" class="form-control" rows="2"></textarea>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('utilizations.index') }}" class="btn btn-default">Kembali</a>
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
