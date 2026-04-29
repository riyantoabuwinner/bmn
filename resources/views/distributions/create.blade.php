@extends('adminlte::page')

@section('title', 'Tambah Distribusi')

@section('content_header')
    <h1>Catat Distribusi Aset</h1>
@stop

@section('content')
    <form action="{{ route('distributions.store') }}" method="POST">
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
                        <option value="">-- Pilih Aset (Tersedia) --</option>
                        @foreach($assets as $asset)
                            <option value="{{ $asset->id }}" {{ old('asset_id', $selected_asset_id) == $asset->id ? 'selected' : '' }}>
                                {{ $asset->kode_barang }} - {{ $asset->nama_barang }} ({{ $asset->kondisi ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                    @error('asset_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="unit_id">Unit Tujuan <span class="text-danger">*</span></label>
                    <select name="unit_id" id="unit_id" class="form-control select2 @error('unit_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Unit --</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                {{ $unit->type == 'rektorat' ? '🏢' : ($unit->type == 'fakultas' ? '🏫' : '📂') }} 
                                {{ $unit->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('unit_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="recipient_name">Nama Penerima <span class="text-danger">*</span></label>
                            <input type="text" name="recipient_name" id="recipient_name" class="form-control @error('recipient_name') is-invalid @enderror" 
                                   value="{{ old('recipient_name') }}" required>
                            @error('recipient_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="recipient_position">Jabatan Penerima <span class="text-danger">*</span></label>
                            <input type="text" name="recipient_position" id="recipient_position" class="form-control @error('recipient_position') is-invalid @enderror" 
                                   value="{{ old('recipient_position') }}" required>
                            @error('recipient_position')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="distribution_date">Tanggal Distribusi <span class="text-danger">*</span></label>
                    <input type="date" name="distribution_date" id="distribution_date" class="form-control @error('distribution_date') is-invalid @enderror" 
                           value="{{ old('distribution_date', date('Y-m-d')) }}" required>
                    @error('distribution_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notes">Catatan Tambahan</label>
                    <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                    @error('notes')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Distribusi
                </button>
                <a href="{{ route('distributions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Initialize Select2 if available
            if ($.fn.select2) {
                $('.select2').select2({
                    theme: 'bootstrap4'
                });
            }
        });
    </script>
@stop
