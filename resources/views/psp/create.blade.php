@extends('adminlte::page')

@section('title', 'Rekam PSP Baru')

@section('content_header')
    <h1>Rekam Penetapan Status Penggunaan (PSP)</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Rekam PSP</h3>
        </div>
        <form action="{{ route('psp.store') }}" method="POST" enctype="multipart/form-data">
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

                <div class="form-group">
                    <label for="asset_id">Pilih Aset</label>
                    <select name="asset_id" id="asset_id" class="form-control select2" required>
                        <option value="">-- Pilih Aset --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="sk_number">Nomor SK PSP</label>
                    <input type="text" name="sk_number" class="form-control" id="sk_number" placeholder="Contoh: KMK-123/2025" required>
                </div>

                <div class="form-group">
                    <label for="sk_date">Tanggal SK</label>
                    <input type="date" name="sk_date" class="form-control" id="sk_date" required>
                </div>

                <div class="form-group">
                    <label for="document">Upload Dokumen SK (PDF/Gambar)</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="document" class="custom-file-input" id="document">
                            <label class="custom-file-label" for="document">Pilih file</label>
                        </div>
                    </div>
                    <small class="text-muted">Max 2MB</small>
                </div>

                <div class="form-group">
                    <label for="notes">Catatan Tambahan</label>
                    <textarea name="notes" class="form-control" id="notes" rows="3"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('psp.index') }}" class="btn btn-default">Kembali</a>
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
