@extends('adminlte::page')

@section('title', 'Edit PSP')

@section('content_header')
    <h1>Edit Data PSP</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Edit PSP</h3>
        </div>
        <form action="{{ route('psp.update', $psp->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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
                        @if($psp->asset)
                            <option value="{{ $psp->asset->id }}" selected>
                                {{ $psp->asset->nama_barang }} - {{ $psp->asset->kode_barang }}
                            </option>
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label for="sk_number">Nomor SK PSP</label>
                    <input type="text" name="sk_number" class="form-control" id="sk_number" value="{{ $psp->sk_number }}" required>
                </div>

                <div class="form-group">
                    <label for="sk_date">Tanggal SK</label>
                    <input type="date" name="sk_date" class="form-control" id="sk_date" value="{{ $psp->sk_date->format('Y-m-d') }}" required>
                </div>

                <div class="form-group">
                    <label for="document">Upload Dokumen SK (Biarkan kosong jika tidak diubah)</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="document" class="custom-file-input" id="document">
                            <label class="custom-file-label" for="document">Pilih file</label>
                        </div>
                    </div>
                    @if($psp->document)
                        <small><a href="{{ asset('storage/' . $psp->document) }}" target="_blank">Lihat Dokumen Saat Ini</a></small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="notes">Catatan Tambahan</label>
                    <textarea name="notes" class="form-control" id="notes" rows="3">{{ $psp->notes }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
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
                placeholder: 'Cari Aset...',
                minimumInputLength: 1
            });
            
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        });
    </script>
@stop
