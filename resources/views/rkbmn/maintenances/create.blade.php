@extends('adminlte::page')

@section('title', 'Tambah Usulan Pemeliharaan')

@section('content_header')
    <h1>Rekam Usulan Pemeliharaan</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('rkbmn.maintenances.store') }}" method="POST">
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
                            <label for="asset_id">Pilih Aset</label>
                            <select name="asset_id" id="asset_id" class="form-control select2" required>
                                <option value="">-- Pilih Aset --</option>
                                @foreach($assets as $asset)
                                    <option value="{{ $asset->id }}">{{ $asset->nama_barang }} - {{ $asset->kode_barang }} ({{ $asset->kondisi }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="maintenance_type">Jenis Pemeliharaan</label>
                            <select name="maintenance_type" class="form-control" required>
                                <option value="Ringan">Ringan (Rutin)</option>
                                <option value="Berat">Berat (Restorasi)</option>
                                <option value="Renovasi">Renovasi (Peningkatan)</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estimated_cost">Estimasi Biaya (Rp)</label>
                            <input type="number" name="estimated_cost" class="form-control" min="0" required>
                        </div>

                        <div class="form-group">
                            <label for="condition_summary">Ringkasan Kondisi Aset Saat Ini</label>
                            <textarea name="condition_summary" class="form-control" rows="2" placeholder="Jelaskan kerusakan atau kondisi aset..." required></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="justification">Justifikasi Kebutuhan Pemeliharaan</label>
                    <textarea name="justification" class="form-control" rows="3" placeholder="Mengapa pemeliharaan ini diperlukan?" required></textarea>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Usulan</button>
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
                            q: params.term // search term
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
        });
    </script>
@stop
