@extends('adminlte::page')

@section('title', 'Edit Monitoring')

@section('content_header')
    <h1>Edit Hasil Monitoring</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('wasdal-monitorings.update', $monitoring->id) }}" method="POST">
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
                                @if($monitoring->asset)
                                    <option value="{{ $monitoring->asset->id }}" selected>
                                        {{ $monitoring->asset->kode_barang }} - {{ $monitoring->asset->nama_barang }}
                                    </option>
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="inspection_date">Tanggal Inspeksi</label>
                            <input type="date" name="inspection_date" class="form-control" value="{{ old('inspection_date', $monitoring->inspection_date->format('Y-m-d')) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="inspector_name">Nama Inspektur</label>
                            <input type="text" name="inspector_name" class="form-control" value="{{ old('inspector_name', $monitoring->inspector_name) }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usage_conformity">Kesesuaian Penggunaan</label>
                            <select name="usage_conformity" class="form-control" required>
                                <option value="Sesuai Peruntukan" {{ $monitoring->usage_conformity == 'Sesuai Peruntukan' ? 'selected' : '' }}>Sesuai Peruntukan</option>
                                <option value="Tidak Sesuai" {{ $monitoring->usage_conformity == 'Tidak Sesuai' ? 'selected' : '' }}>Tidak Sesuai Peruntukan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="is_idle">Status Idle / Terlantar</label>
                            <select name="is_idle" class="form-control" required>
                                <option value="0" {{ !$monitoring->is_idle ? 'selected' : '' }}>Tidak (Aktif Digunakan)</option>
                                <option value="1" {{ $monitoring->is_idle ? 'selected' : '' }}>Ya (Idle / Terlantar)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="notes">Catatan</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $monitoring->notes) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Perbarui Data</button>
                <a href="{{ route('wasdal-monitorings.index') }}" class="btn btn-default">Kembali</a>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
             $('.select2').select2({
                ajax: {
                    url: "{{ route('assets.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { q: params.term };
                    },
                    processResults: function (data) {
                        return { results: data };
                    },
                    cache: true
                },
                placeholder: 'Cari Aset...',
                minimumInputLength: 1
            });
        });
    </script>
@stop
