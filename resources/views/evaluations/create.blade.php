@extends('adminlte::page')

@section('title', 'Mulai Evaluasi Baru')

@section('content_header')
    <h1>Mulai Periode Evaluasi Aset</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('evaluations.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Memulai evaluasi baru akan secara otomatis memuat seluruh data <strong>Aset Tetap</strong> yang aktif untuk dilakukan pengecekan kondisi.
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tahun Evaluasi</label>
                    <div class="col-sm-4">
                        <input type="number" name="year" class="form-control" value="{{ date('Y') }}" required min="2000" max="{{ date('Y')+1 }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tipe Periode</label>
                    <div class="col-sm-4">
                        <select name="period_type" id="period_type" class="form-control" required>
                            <option value="semester">Semester</option>
                            <option value="annual">Tahunan</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row" id="semester_group">
                    <label class="col-sm-2 col-form-label">Semester</label>
                    <div class="col-sm-4">
                        <select name="semester" class="form-control">
                            <option value="1">Semester 1 (Jan - Jun)</option>
                            <option value="2">Semester 2 (Jul - Des)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Mulai & Load Data Aset</button>
                <a href="{{ route('evaluations.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#period_type').change(function() {
                if($(this).val() == 'annual') {
                    $('#semester_group').hide();
                } else {
                    $('#semester_group').show();
                }
            });
        });
    </script>
@stop
