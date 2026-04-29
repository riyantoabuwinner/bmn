@extends('adminlte::page')

@section('title', 'Rekam Penghapusan')

@section('content_header')
    <h1>Rekam Penghapusan Aset</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('deletions.store') }}" method="POST" enctype="multipart/form-data">
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

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Peringatan: Merekam penghapusan akan secara otomatis menonaktifkan aset dari daftar aset aktif.
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="asset_id">Pilih Aset</label>
                            <select name="asset_id" id="asset_id" class="form-control select2" required>
                                <option value="">-- Pilih Aset --</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="deletion_type">Jenis Penghapusan</label>
                            <select name="deletion_type" id="deletion_type" class="form-control" required>
                                <option value="Rusak Berat">Rusak Berat</option>
                                <option value="Hilang">Hilang / Kecurian</option>
                                <option value="Putusan Pengadilan">Putusan Pengadilan</option>
                                <option value="Peraturan Perundang-undangan">Peraturan Perundang-undangan</option>
                                <option value="Sebab Lain">Sebab Lain</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="value">Nilai Buku Saat Dihapus (Opsional) - Rp</label>
                            <input type="number" name="value" class="form-control" value="0" min="0">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sk_number">Nomor SK Penghapusan</label>
                            <input type="text" name="sk_number" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="sk_date">Tanggal SK</label>
                            <input type="date" name="sk_date" class="form-control" required>
                        </div>

                         <div class="form-group">
                            <label for="document">Upload Dokumen SK</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="document" class="custom-file-input" id="document">
                                    <label class="custom-file-label" for="document">Pilih file</label>
                                </div>
                            </div>
                            <small class="text-muted">Max 2MB (PDF/JPG/PNG)</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Keterangan / Alasan Detail</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-danger">Rekam Penghapusan</button>
                <a href="{{ route('deletions.index') }}" class="btn btn-default">Kembali</a>
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
