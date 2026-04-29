@extends('adminlte::page')

@section('title', 'Edit Pemanfaatan')

@section('content_header')
    <h1>Edit Data Pemanfaatan</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('utilizations.update', $utilization->id) }}" method="POST" enctype="multipart/form-data">
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
                                @if($utilization->asset)
                                    <option value="{{ $utilization->asset->id }}" selected>
                                        {{ $utilization->asset->nama_barang }} - {{ $utilization->asset->kode_barang }}
                                    </option>
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="utilization_type">Bentuk Pemanfaatan</label>
                            <select name="utilization_type" id="utilization_type" class="form-control" required>
                                @foreach(['Sewa', 'Pinjam Pakai', 'KSP', 'BGS', 'BSG'] as $type)
                                    <option value="{{ $type }}" {{ $utilization->utilization_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="partner_name">Pihak Ketiga (Mitra)</label>
                            <input type="text" name="partner_name" class="form-control" value="{{ $utilization->partner_name }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contract_number">Nomor Perjanjian/Kontrak</label>
                            <input type="text" name="contract_number" class="form-control" value="{{ $utilization->contract_number }}" required>
                        </div>

                        <div class="form-group">
                            <label for="contract_date">Tanggal Perjanjian</label>
                            <input type="date" name="contract_date" class="form-control" value="{{ $utilization->contract_date->format('Y-m-d') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="start_date">Mulai</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ $utilization->start_date->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="end_date">Berakhir</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ $utilization->end_date->format('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                         <div class="form-group">
                            <label for="value">Nilai Pemanfaatan (PNBP) - Rp</label>
                            <input type="number" name="value" class="form-control" value="{{ $utilization->value }}" min="0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="document">Upload Dokumen (Biarkan kosong jika tidak berubah)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="document" class="custom-file-input" id="document">
                                    <label class="custom-file-label" for="document">Pilih file</label>
                                </div>
                            </div>
                            @if($utilization->document)
                                <small><a href="{{ asset('storage/' . $utilization->document) }}" target="_blank">Lihat Dokumen Saat Ini</a></small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Keterangan Lain</label>
                    <textarea name="description" class="form-control" rows="2">{{ $utilization->description }}</textarea>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
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
