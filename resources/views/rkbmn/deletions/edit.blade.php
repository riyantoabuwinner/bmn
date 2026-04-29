@extends('adminlte::page')

@section('title', 'Edit Usulan Penghapusan')

@section('content_header')
    <h1>Edit Usulan Penghapusan</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('rkbmn.deletions.update', $deletion) }}" method="POST">
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
                            <label for="year">Tahun Anggaran</label>
                            <input type="number" name="year" class="form-control" value="{{ $deletion->year }}" min="2025" max="2030" required>
                        </div>

                        <div class="form-group">
                            <label for="asset_id">Pilih Aset</label>
                            <select name="asset_id" id="asset_id" class="form-control select2" required>
                                @if($deletion->asset)
                                    <option value="{{ $deletion->asset->id }}" selected>
                                        {{ $deletion->asset->nama_barang }} - {{ $deletion->asset->kode_barang }}
                                    </option>
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="deletion_type">Alasan Penghapusan</label>
                            <select name="deletion_type" class="form-control" required>
                                @foreach(['Rusak Berat', 'Hilang', 'Sebab Lain'] as $type)
                                    <option value="{{ $type }}" {{ $deletion->deletion_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="justification">Justifikasi Usulan</label>
                            <textarea name="justification" class="form-control" rows="4" required>{{ $deletion->justification }}</textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Usulan</button>
                <a href="{{ route('rkbmn.deletions.index') }}" class="btn btn-default">Kembali</a>
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
        });
    </script>
@stop
