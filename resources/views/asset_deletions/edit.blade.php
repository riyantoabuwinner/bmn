@extends('adminlte::page')

@section('title', 'Edit Penghapusan')

@section('content_header')
    <h1>Edit Data Penghapusan</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('deletions.update', $deletion->id) }}" method="POST" enctype="multipart/form-data">
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

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="asset_id">Pilih Aset</label>
                            <select name="asset_id" id="asset_id" class="form-control select2" required>
                                @if($deletion->asset)
                                    <option value="{{ $deletion->asset->id }}" selected>
                                        {{ $deletion->asset->nama_barang }} - {{ $deletion->asset->kode_barang }}
                                    </option>
                                @elseif($deletion->asset_id)
                                    <!-- Fallback if relation is null due to soft delete (though logic should handle this) -->
                                     <option value="{{ $deletion->asset_id }}" selected>
                                        Aset ID: {{ $deletion->asset_id }} (Mungkin terhapus)
                                    </option>
                                @endif
                            </select>
                            <small class="text-muted">Aset yang sudah dihapus mungkin tidak muncul di pencarian jika status soft-deleted.</small>
                        </div>

                        <div class="form-group">
                            <label for="deletion_type">Jenis Penghapusan</label>
                            <select name="deletion_type" id="deletion_type" class="form-control" required>
                                @foreach(['Rusak Berat', 'Hilang', 'Putusan Pengadilan', 'Peraturan Perundang-undangan', 'Sebab Lain'] as $type)
                                    <option value="{{ $type }}" {{ $deletion->deletion_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="value">Nilai Buku Saat Dihapus (Opsional) - Rp</label>
                            <input type="number" name="value" class="form-control" value="{{ $deletion->value }}" min="0">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sk_number">Nomor SK Penghapusan</label>
                            <input type="text" name="sk_number" class="form-control" value="{{ $deletion->sk_number }}" required>
                        </div>

                        <div class="form-group">
                            <label for="sk_date">Tanggal SK</label>
                            <input type="date" name="sk_date" class="form-control" value="{{ $deletion->sk_date->format('Y-m-d') }}" required>
                        </div>

                         <div class="form-group">
                            <label for="document">Upload Dokumen SK (Biarkan kosong jika tidak berubah)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="document" class="custom-file-input" id="document">
                                    <label class="custom-file-label" for="document">Pilih file</label>
                                </div>
                            </div>
                            @if($deletion->document)
                                <small><a href="{{ asset('storage/' . $deletion->document) }}" target="_blank">Lihat Dokumen Saat Ini</a></small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Keterangan / Alasan Detail</label>
                    <textarea name="description" class="form-control" rows="3">{{ $deletion->description }}</textarea>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
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
