@extends('adminlte::page')

@section('title', 'Tambah Usulan Aksi')

@section('content_header')
    <h1>Rekam Usulan Pemanfaatan/Pemindahtanganan</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('rkbmn.actions.store') }}" method="POST">
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
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="action_type">Jenis Usulan</label>
                            <select name="action_type" class="form-control" required>
                                <optgroup label="Pemanfaatan">
                                    <option value="Sewa">Sewa</option>
                                    <option value="Pinjam Pakai">Pinjam Pakai</option>
                                    <option value="KSP">Kerjasama Pemanfaatan</option>
                                </optgroup>
                                <optgroup label="Pemindahtanganan">
                                    <option value="Penjualan">Penjualan/Lelang</option>
                                    <option value="Hibah">Hibah</option>
                                    <option value="Tukar Menukar">Tukar Menukar</option>
                                    <option value="PMN">Penyertaan Modal Koperasi (PMN)</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estimated_revenue">Estimasi Penerimaan Negara (PNBP) - Rp</label>
                            <input type="number" name="estimated_revenue" class="form-control" min="0" value="0" required>
                            <small class="text-muted">Isi 0 jika tidak menghasilkan pendapatan (misal: Hibah/Pinjam Pakai)</small>
                        </div>

                        <div class="form-group">
                            <label for="justification">Justifikasi Usulan</label>
                            <textarea name="justification" class="form-control" rows="4" placeholder="Alasan melakukan aksi ini..." required></textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Usulan</button>
                <a href="{{ route('rkbmn.actions.index') }}" class="btn btn-default">Kembali</a>
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
                placeholder: 'Cari Aset (Nama/Kode/NUP)...',
                minimumInputLength: 1
            });
        });
    </script>
@stop
