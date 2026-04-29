@extends('adminlte::page')

@section('title', 'Input Evaluasi Kinerja')

@section('content_header')
    <h1>Input Evaluasi Kinerja Aset</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Evaluasi SBSK</h3>
        </div>
        <form action="{{ route('performances.store') }}" method="POST">
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
                            <label>Tanggal Evaluasi <span class="text-danger">*</span></label>
                            <input type="date" name="evaluation_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kategori Aset (Portofolio) <span class="text-danger">*</span></label>
                            <select name="category" class="form-control" required>
                                <option value="Gedung Bangunan Kantor">Gedung Bangunan Kantor</option>
                                <option value="Rumah Negara">Rumah Negara</option>
                                <option value="Alat Angkutan">Alat Angkutan</option>
                                <option value="Tanah">Tanah</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Target SBSK (m2 / unit) <span class="text-danger">*</span></label>
                            <input type="number" name="sbsk_target" id="sbsk_target" class="form-control" step="0.01" required placeholder="Contoh: 100">
                            <small class="text-muted">Standar kebutuhan yang seharusnya.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kondisi Eksisting (m2 / unit) <span class="text-danger">*</span></label>
                            <input type="number" name="actual_usage" id="actual_usage" class="form-control" step="0.01" required placeholder="Contoh: 50">
                            <small class="text-muted">Luas atau jumlah yang tersedia saat ini.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Estimasi Efisiensi</label>
                            <input type="text" id="efficiency_display" class="form-control" readonly style="font-weight: bold;">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Rekomendasi / Tindak Lanjut</label>
                    <textarea name="recommendation" class="form-control" rows="3" placeholder="Contoh: Perlu optimalisasi penggunaan ruang..."></textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Evaluasi</button>
                <a href="{{ route('performances.index') }}" class="btn btn-default">Batal</a>
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

        // Auto calculate efficiency
        function calculateEfficiency() {
            let target = parseFloat($('#sbsk_target').val()) || 0;
            let actual = parseFloat($('#actual_usage').val()) || 0;
            
            if (target > 0) {
                let ratio = (actual / target) * 100;
                let status = '';
                
                if (ratio > 110) status = ' (Overutilized)';
                else if (ratio < 90) status = ' (Underutilized)';
                else status = ' (Optimal)';

                $('#efficiency_display').val(ratio.toFixed(2) + '%' + status);
                
                if (status.includes('Over')) $('#efficiency_display').css('color', 'red');
                else if (status.includes('Under')) $('#efficiency_display').css('color', 'orange');
                else $('#efficiency_display').css('color', 'green');
            } else {
                $('#efficiency_display').val('-');
            }
        }

        $('#sbsk_target, #actual_usage').on('input', calculateEfficiency);
    });
</script>
@stop
