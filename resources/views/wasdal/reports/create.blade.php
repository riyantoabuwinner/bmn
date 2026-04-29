@extends('adminlte::page')

@section('title', 'Buat Laporan Wasdal')

@section('content_header')
    <h1>Rekam Pelaporan Wasdal</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('wasdal-reports.store') }}" method="POST" enctype="multipart/form-data">
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
                            <label for="asset_id">Pilih Aset</label>
                            <select name="asset_id" id="asset_id" class="form-control select2" required>
                                <option value="">-- Cari Aset --</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="period_year">Tahun Periode</label>
                            <input type="number" name="period_year" class="form-control" value="{{ date('Y') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="report_type">Jenis Laporan</label>
                            <select name="report_type" class="form-control" required>
                                <option value="Tahunan">Tahunan</option>
                                <option value="Semester I">Semester I</option>
                                <option value="Semester II">Semester II</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="condition_status">Status Kondisi (Saat Ini)</label>
                            <select name="condition_status" class="form-control" required>
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="usage_status">Status Penggunaan</label>
                            <select name="usage_status" class="form-control" required>
                                <option value="Digunakan">Digunakan Sesuai PSP</option>
                                <option value="Idle">Idle / Tidak Digunakan</option>
                                <option value="Digunakan Pihak Lain">Digunakan Pihak Lain</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="document">Upload Lampiran (PDF/Laporan)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="document" class="custom-file-input">
                                    <label class="custom-file-label">Pilih file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Catatan / Keterangan Tambahan</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Laporan</button>
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
