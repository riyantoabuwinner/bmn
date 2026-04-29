@extends('adminlte::page')

@section('title', 'Rekam Monitoring')

@section('content_header')
    <h1>Rekam Hasil Monitoring Lapangan</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('wasdal-monitorings.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="asset_id">Pilih Aset</label>
                            <select name="asset_id" id="asset_id" class="form-control select2" required>
                                <option value="">-- Cari Aset --</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="inspection_date">Tanggal Inspeksi</label>
                            <input type="date" name="inspection_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="inspector_name">Nama Inspektur / Petugas</label>
                            <input type="text" name="inspector_name" class="form-control" value="{{ auth()->user()->name }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usage_conformity">Kesesuaian Penggunaan</label>
                            <select name="usage_conformity" class="form-control" required>
                                <option value="Sesuai Peruntukan">Sesuai Peruntukan (PSP)</option>
                                <option value="Tidak Sesuai">Tidak Sesuai (Pihak Lain Tanpa Izin)</option>
                                <option value="Alih Fungsi">Alih Fungsi</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="is_idle">Status Idle (Terlantar)</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_idle" value="1">
                                <label class="form-check-label text-warning"><b>Ya, Aset Sedang Idle</b></label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_idle" value="0" checked>
                                <label class="form-check-label">Tidak, Aset Digunakan Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Catatan Hasil Monitoring Lapangan</label>
                    <textarea name="notes" class="form-control" rows="4" placeholder="Jelaskan kondisi fisik dan situasi penggunaan aset..."></textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Record Monitoring</button>
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
