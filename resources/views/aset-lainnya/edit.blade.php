@extends('adminlte::page')

@section('title', 'Edit Aset Lainnya')

@section('content_header')
    <h1>Edit Aset Lainnya</h1>
@stop

@section('content')
    <form action="{{ route('aset-lainnya.update', $asetLainnya) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Aset <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $asetLainnya->name }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipe Aset <span class="text-danger">*</span></label>
                            <select name="asset_type" class="form-control" required>
                                <option value="lisensi" {{ $asetLainnya->asset_type == 'lisensi' ? 'selected' : '' }}>Lisensi</option>
                                <option value="paten" {{ $asetLainnya->asset_type == 'paten' ? 'selected' : '' }}>Paten</option>
                                <option value="hak_cipta" {{ $asetLainnya->asset_type == 'hak_cipta' ? 'selected' : '' }}>Hak Cipta</option>
                                <option value="hak_sewa" {{ $asetLainnya->asset_type == 'hak_sewa' ? 'selected' : '' }}>Hak Sewa</option>
                                <option value="lainnya" {{ $asetLainnya->asset_type == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="active" {{ $asetLainnya->status == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ $asetLainnya->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                <option value="expired" {{ $asetLainnya->status == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $asetLainnya->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Unit Pemilik <span class="text-danger">*</span></label>
                            <select name="unit_id" class="form-control" required>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" {{ $asetLainnya->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Lokasi <span class="text-danger">*</span></label>
                            <select name="location_id" class="form-control" required>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ $asetLainnya->location_id == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nilai Perolehan (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="purchase_value" class="form-control" value="{{ $asetLainnya->purchase_value }}" min="0" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nilai Saat Ini (Rp)</label>
                            <input type="number" name="current_value" class="form-control" value="{{ $asetLainnya->current_value }}" min="0">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Perolehan <span class="text-danger">*</span></label>
                            <input type="date" name="purchase_date" class="form-control" value="{{ $asetLainnya->purchase_date->format('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Mulai Berlaku</label>
                            <input type="date" name="start_date" class="form-control" value="{{ $asetLainnya->start_date ? $asetLainnya->start_date->format('Y-m-d') : '' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Berakhir</label>
                            <input type="date" name="end_date" class="form-control" value="{{ $asetLainnya->end_date ? $asetLainnya->end_date->format('Y-m-d') : '' }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ $asetLainnya->description }}</textarea>
                </div>

                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="notes" class="form-control" rows="2">{{ $asetLainnya->notes }}</textarea>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{ route('aset-lainnya.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </div>
    </form>
@stop
