@extends('adminlte::page')

@section('title', 'Edit Laporan Wasdal')

@section('content_header')
    <h1>Edit Pelaporan Wasdal</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('wasdal-reports.update', $report->id) }}" method="POST" enctype="multipart/form-data">
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
                                @if($report->asset)
                                    <option value="{{ $report->asset->id }}" selected>
                                        {{ $report->asset->kode_barang }} - {{ $report->asset->nama_barang }}
                                    </option>
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="period_year">Tahun Periode</label>
                            <input type="number" name="period_year" class="form-control" value="{{ old('period_year', $report->period_year) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="report_type">Jenis Laporan</label>
                            <select name="report_type" class="form-control" required>
                                <option value="Tahunan" {{ $report->report_type == 'Tahunan' ? 'selected' : '' }}>Tahunan</option>
                                <option value="Semester I" {{ $report->report_type == 'Semester I' ? 'selected' : '' }}>Semester I</option>
                                <option value="Semester II" {{ $report->report_type == 'Semester II' ? 'selected' : '' }}>Semester II</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="condition_status">Status Kondisi</label>
                            <select name="condition_status" class="form-control" required>
                                <option value="Baik" {{ $report->condition_status == 'Baik' ? 'selected' : '' }}>Baik</option>
                                <option value="Rusak Ringan" {{ $report->condition_status == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="Rusak Berat" {{ $report->condition_status == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="usage_status">Status Penggunaan</label>
                            <select name="usage_status" class="form-control" required>
                                <option value="Digunakan" {{ $report->usage_status == 'Digunakan' ? 'selected' : '' }}>Digunakan Sesuai PSP</option>
                                <option value="Idle" {{ $report->usage_status == 'Idle' ? 'selected' : '' }}>Idle / Tidak Digunakan</option>
                                <option value="Digunakan Pihak Lain" {{ $report->usage_status == 'Digunakan Pihak Lain' ? 'selected' : '' }}>Digunakan Pihak Lain</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="document">Upload Lampiran (PDF/Laporan)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="document" class="custom-file-input">
                                    <label class="custom-file-label">{{ $report->document ? basename($report->document) : 'Pilih file' }}</label>
                                </div>
                            </div>
                            @if($report->document)
                                <small class="text-muted">File saat ini: {{ basename($report->document) }}</small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Catatan / Keterangan Tambahan</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $report->description) }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Perbarui Laporan</button>
                <a href="{{ route('wasdal-reports.index') }}" class="btn btn-default">Kembali</a>
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

            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        });
    </script>
@stop
