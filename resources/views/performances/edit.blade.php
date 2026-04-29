@extends('adminlte::page')

@section('title', 'Edit Evaluasi Kinerja')

@section('content_header')
    <h1>Edit Evaluasi Kinerja Aset</h1>
@stop

@section('content')
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Update Data Evaluasi: {{ $performance->asset->nama_barang }}</h3>
        </div>
        <form action="{{ route('performances.update', $performance) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Evaluasi <span class="text-danger">*</span></label>
                            <input type="date" name="evaluation_date" class="form-control" value="{{ old('evaluation_date', $performance->evaluation_date->format('Y-m-d')) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kategori Aset (Portofolio) <span class="text-danger">*</span></label>
                            <select name="category" class="form-control" required>
                                <option value="Gedung Bangunan Kantor" {{ $performance->category == 'Gedung Bangunan Kantor' ? 'selected' : '' }}>Gedung Bangunan Kantor</option>
                                <option value="Rumah Negara" {{ $performance->category == 'Rumah Negara' ? 'selected' : '' }}>Rumah Negara</option>
                                <option value="Alat Angkutan" {{ $performance->category == 'Alat Angkutan' ? 'selected' : '' }}>Alat Angkutan</option>
                                <option value="Tanah" {{ $performance->category == 'Tanah' ? 'selected' : '' }}>Tanah</option>
                                <option value="Lainnya" {{ $performance->category == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Target SBSK (m2 / unit) <span class="text-danger">*</span></label>
                            <input type="number" name="sbsk_target" id="sbsk_target" class="form-control" step="0.01" value="{{ old('sbsk_target', $performance->sbsk_target) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kondisi Eksisting (m2 / unit) <span class="text-danger">*</span></label>
                            <input type="number" name="actual_usage" id="actual_usage" class="form-control" step="0.01" value="{{ old('actual_usage', $performance->actual_usage) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Estimasi Efisiensi</label>
                            <input type="text" id="efficiency_display" class="form-control" readonly style="font-weight: bold;" value="{{ $performance->efficiency_ratio }}%">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Rekomendasi / Tindak Lanjut</label>
                    <textarea name="recommendation" class="form-control" rows="3">{{ old('recommendation', $performance->recommendation) }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('performances.index') }}" class="btn btn-default">Batal</a>
            </div>
        </form>
    </div>
@stop

@section('js')
<script>
    $(document).ready(function() {
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
        calculateEfficiency(); // Trigger on load
    });
</script>
@stop
