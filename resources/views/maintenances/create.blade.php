@extends('adminlte::page')

@section('title', 'Jadwalkan Maintenance')

@section('content_header')
    <h1>Jadwalkan Maintenance</h1>
@stop

@section('content')
    <form action="{{ route('maintenances.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                @if(isset($selected_asset_id))
                    <div class="alert alert-info">
                        Debug: Asset ID selected is {{ $selected_asset_id }}
                    </div>
                @endif
                <div class="form-group">
                    <label for="asset_id">Pilih Aset <span class="text-danger">*</span></label>
                    <select name="asset_id" id="asset_id" class="form-control select2 @error('asset_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Aset --</option>
                        @foreach($assets as $asset)
                            <option value="{{ $asset->id }}" {{ old('asset_id', $selected_asset_id) == $asset->id ? 'selected' : '' }}>
                                {{ $asset->kode_barang }} - {{ $asset->nama_barang }} ({{ $asset->kondisi }})
                            </option>
                        @endforeach
                    </select>
                    @error('asset_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="maintenance_type">Tipe Maintenance <span class="text-danger">*</span></label>
                            <select name="maintenance_type" id="maintenance_type" class="form-control @error('maintenance_type') is-invalid @enderror" required>
                                <option value="rutin" {{ old('maintenance_type') == 'rutin' ? 'selected' : '' }}>Rutin</option>
                                <option value="perbaikan" {{ old('maintenance_type') == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                                <option value="kalibrasi" {{ old('maintenance_type') == 'kalibrasi' ? 'selected' : '' }}>Kalibrasi</option>
                            </select>
                            @error('maintenance_type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="scheduled_date">Tanggal Jadwal <span class="text-danger">*</span></label>
                            <input type="date" name="scheduled_date" id="scheduled_date" class="form-control @error('scheduled_date') is-invalid @enderror" 
                                   value="{{ old('scheduled_date', date('Y-m-d')) }}" required>
                            @error('scheduled_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="estimated_cost">Estimasi Biaya (Rp)</label>
                    <input type="number" name="estimated_cost" id="estimated_cost" class="form-control @error('estimated_cost') is-invalid @enderror" 
                           value="{{ old('estimated_cost') }}" min="0">
                    @error('estimated_cost')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi Pengerjaan <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Jadwalkan
                </button>
                <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            if ($.fn.select2) {
                $('.select2').select2({theme: 'bootstrap4'});
            }
        });
    </script>
@stop
