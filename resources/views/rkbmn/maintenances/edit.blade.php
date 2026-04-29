@extends('adminlte::page')

@section('title', 'Edit Usulan Pemeliharaan')

@section('content_header')
    <h1>Edit Usulan Pemeliharaan</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('rkbmn.maintenances.update', $maintenance) }}" method="POST">
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
                            <input type="number" name="year" class="form-control" value="{{ $maintenance->year }}" min="2025" max="2030" required>
                        </div>

                        <div class="form-group">
                            <label for="asset_id">Pilih Aset</label>
                            <select name="asset_id" id="asset_id" class="form-control select2" required>
                                @if($maintenance->asset)
                                    <option value="{{ $maintenance->asset->id }}" selected>
                                        {{ $maintenance->asset->nama_barang }} - {{ $maintenance->asset->kode_barang }}
                                    </option>
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="maintenance_type">Jenis Pemeliharaan</label>
                            <select name="maintenance_type" class="form-control" required>
                                @foreach(['Ringan', 'Berat', 'Renovasi'] as $type)
                                    <option value="{{ $type }}" {{ $maintenance->maintenance_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estimated_cost">Estimasi Biaya (Rp)</label>
                            <input type="number" name="estimated_cost" class="form-control" value="{{ $maintenance->estimated_cost }}" min="0" required>
                        </div>

                        <div class="form-group">
                            <label for="condition_summary">Ringkasan Kondisi Aset Saat Ini</label>
                            <textarea name="condition_summary" class="form-control" rows="2" required>{{ $maintenance->condition_summary }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="justification">Justifikasi Kebutuhan Pemeliharaan</label>
                    <textarea name="justification" class="form-control" rows="3" required>{{ $maintenance->justification }}</textarea>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Usulan</button>
                <a href="{{ route('rkbmn.maintenances.index') }}" class="btn btn-default">Kembali</a>
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
