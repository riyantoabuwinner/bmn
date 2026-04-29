@extends('adminlte::page')

@section('title', 'Daftar Objek Asuransi')

@section('content_header')
    <h1>Daftar Objek Asuransi</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Pendaftaran Asuransi BMN</h3>
        </div>
        <form action="{{ route('insurances.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Pilih Aset <span class="text-danger">*</span></label>
                    <select name="asset_id" id="asset_select" class="form-control select2" required style="width: 100%;">
                        <option value="">-- Cari Nama/Kode Barang --</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nomor Polis</label>
                            <input type="text" name="policy_number" class="form-control" placeholder="Masukkan nomor polis">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Perusahaan Asuransi</label>
                            <input type="text" name="insurance_company" class="form-control" placeholder="Masukkan nama perusahaan">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Berakhir</label>
                            <input type="date" name="end_date" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nilai Pertanggungan (Rp)</label>
                            <input type="number" name="coverage_amount" class="form-control" step="0.01">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nilai Premi (Rp)</label>
                            <input type="number" name="premium_amount" class="form-control" step="0.01">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="Usulan">Usulan</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Berakhir">Berakhir</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Dokumen Polis (PDF/JPG/PNG)</label>
                            <input type="file" name="document" class="form-control-file">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="notes" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Pendaftaran</button>
                <a href="{{ route('insurances.index') }}" class="btn btn-default">Batal</a>
            </div>
        </form>
    </div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#asset_select').select2({
            placeholder: '-- Cari Nama/Kode Barang --',
            ajax: {
                url: "{{ route('assets.search') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return { results: data };
                },
                cache: true
            },
            minimumInputLength: 3
        });
    });
</script>
@stop
