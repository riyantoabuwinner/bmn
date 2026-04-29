@extends('adminlte::page')

@section('plugins.Select2', true)

@section('title', 'Buat Usulan Penghapusan')

@section('content_header')
    <h1>Buat Usulan Penghapusan</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('deletions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tipe Aset <span class="text-danger">*</span></label>
                            <select name="asset_type" id="asset_type" class="form-control" required>
                                <option value="AsetTetap" {{ old('asset_type', $selected_asset_type == 'AsetTetap' ? 'AsetTetap' : '') == 'AsetTetap' ? 'selected' : '' }}>Aset Tetap</option>
                                <option value="AsetLainnya" {{ old('asset_type', $selected_asset_type == 'AsetLainnya' ? 'AsetLainnya' : '') == 'AsetLainnya' ? 'selected' : '' }}>Aset Lainnya</option>
                            </select>
                        </div>
                        
                        <div class="form-group" id="group_aset_tetap">
                            <label>Pilih Aset Tetap <span class="text-danger">*</span></label>
                            <select name="asset_id_tetap" id="asset_id_tetap" class="form-control select2" style="width: 100%;">
                                <option value="">-- Pilih Aset --</option>
                                @foreach($asetTetap as $asset)
                                    <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id || $selected_asset_id == $asset->id ? 'selected' : '' }}>
                                        {{ $asset->kode_barang }} - {{ $asset->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group d-none" id="group_aset_lainnya">
                            <label>Pilih Aset Lainnya <span class="text-danger">*</span></label>
                            <select name="asset_id_lainnya" id="asset_id_lainnya" class="form-control select2" style="width: 100%;">
                                <option value="">-- Pilih Aset --</option>
                                @foreach($asetLainnya as $asset)
                                    <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                                        {{ $asset->kode_barang }} - {{ $asset->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Hidden input to store final asset_id -->
                        <input type="hidden" name="asset_id" id="final_asset_id">

                        <div class="form-group">
                            <label>Tanggal Usulan <span class="text-danger">*</span></label>
                            <input type="date" name="proposal_date" class="form-control" value="{{ old('proposal_date', date('Y-m-d')) }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Alasan Penghapusan <span class="text-danger">*</span></label>
                            <textarea name="reason" class="form-control" rows="4" required placeholder="Jelaskan kondisi aset dan alasan mengapa perlu dihapus...">{{ old('reason') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Dokumen Pendukung (PDF/Gambar)</label>
                            <div class="custom-file">
                                <input type="file" name="document" class="custom-file-input" id="document">
                                <label class="custom-file-label" for="document">Pilih file...</label>
                            </div>
                            <small class="text-muted">Max 2MB. Contoh: Foto kondisi rusak, Berita Acara Kerusakan, dll.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" onclick="prepareSubmit()">Ajukan Penghapusan</button>
                <a href="{{ route('deletions.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({theme: 'bootstrap4'});
            bsCustomFileInput.init();

            // Handle Type Change
            $('#asset_type').change(function() {
                toggleAssetSelect();
            });

            function toggleAssetSelect() {
                var type = $('#asset_type').val();
                if(type === 'AsetTetap') {
                    $('#group_aset_tetap').removeClass('d-none');
                    $('#group_aset_lainnya').addClass('d-none');
                    $('#asset_id_lainnya').val(null).trigger('change'); // Reset other
                } else {
                    $('#group_aset_tetap').addClass('d-none');
                    $('#group_aset_lainnya').removeClass('d-none');
                    $('#asset_id_tetap').val(null).trigger('change'); // Reset other
                }
            }

            // Init state
            toggleAssetSelect();
        });

        function prepareSubmit() {
            var type = $('#asset_type').val();
            if(type === 'AsetTetap') {
                $('#final_asset_id').val($('#asset_id_tetap').val());
            } else {
                $('#final_asset_id').val($('#asset_id_lainnya').val());
            }
        }
    </script>
@stop
