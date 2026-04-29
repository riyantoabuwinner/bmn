@extends('adminlte::page')

@section('title', 'Serah Terima Aset')

@section('content_header')
    <h1>Serah Terima Aset</h1>
@stop

@section('plugins.Select2', true)

@section('content')
    <div class="card">
        <form action="{{ route('assignments.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Informasi Aset</h4>
                        <div class="form-group">
                            <label for="asset_id">Pilih Aset <span class="text-danger">*</span></label>
                            <select name="asset_id" id="asset_id" class="form-control select2" required>
                                <option value="">-- Pilih Aset --</option>
                                @foreach($assets as $asset)
                                    <option value="{{ $asset->id }}" {{ old('asset_id', $selected_asset_id) == $asset->id ? 'selected' : '' }}>
                                        {{ $asset->kode_barang }} - {{ $asset->nama_barang }} ({{ ucfirst($asset->kondisi) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="assigned_date">Tanggal Penyerahan <span class="text-danger">*</span></label>
                            <input type="date" name="assigned_date" class="form-control" value="{{ old('assigned_date', date('Y-m-d')) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="condition_on_assign">Kondisi Aset Saat Ini <span class="text-danger">*</span></label>
                            <select name="condition_on_assign" class="form-control" required>
                                <option value="baik">Baik</option>
                                <option value="rusak_ringan">Rusak Ringan</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h4>Informasi Penerima / Pemegang</h4>
                        
                        <div class="form-group">
                            <label for="user_id">Pilih dari User Sistem (Opsional)</label>
                            <select name="user_id" id="user_id" class="form-control select2">
                                <option value="">-- Manual Input (Luar Sistem) --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Jika user dipilih, nama & data lain akan terisi otomatis.</small>
                        </div>

                        <div class="form-group">
                            <label for="employee_name">Nama Pemegang <span class="text-danger">*</span></label>
                            <input type="text" name="employee_name" id="employee_name" class="form-control" value="{{ old('employee_name') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="employee_id_number">NIP / No. Identitas</label>
                                    <input type="text" name="employee_id_number" class="form-control" value="{{ old('employee_id_number') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="position">Jabatan</label>
                                    <input type="text" name="position" class="form-control" value="{{ old('position') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="department">Unit / Divisi</label>
                            <input type="text" name="department" class="form-control" value="{{ old('department') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Catatan Serah Terima</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan & Buat BAST</button>
                <a href="{{ route('assignments.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({theme: 'bootstrap4'});

            // Auto-fill Name when User is selected (Simple JS logic)
            $('#user_id').change(function() {
                var selectedText = $(this).find("option:selected").text().trim();
                if(selectedText && $(this).val() !== "") {
                    // Extract name from "Name (Email)" format used in option text
                    var name = selectedText.split('(')[0].trim();
                    $('#employee_name').val(name);
                }
            });
        });
    </script>
@stop
