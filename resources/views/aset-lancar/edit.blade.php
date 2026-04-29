@extends('adminlte::page')

@section('title', 'Edit Aset Lancar')

@section('content_header')
    <h1>Edit Aset Lancar</h1>
@stop

@section('content')
    <form action="{{ route('aset-lancar.update', $asetLancar) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Aset <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $asetLancar->name) }}" required>
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $asetLancar->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Kondisi <span class="text-danger">*</span></label>
                            <select name="condition_status" class="form-control" required>
                                <option value="baik" {{ $asetLancar->condition_status == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak" {{ $asetLancar->condition_status == 'rusak' ? 'selected' : '' }}>Rusak</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Unit Pemilik <span class="text-danger">*</span></label>
                            <select name="unit_id" class="form-control" required>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" {{ $asetLancar->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Lokasi <span class="text-danger">*</span></label>
                            <select name="location_id" class="form-control" required>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ $asetLancar->location_id == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Pembelian <span class="text-danger">*</span></label>
                            <input type="date" name="purchase_date" class="form-control" value="{{ $asetLancar->purchase_date->format('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Jumlah Stok <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" class="form-control" value="{{ $asetLancar->quantity }}" min="0" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Satuan <span class="text-danger">*</span></label>
                            <input type="text" name="unit_of_measure" class="form-control" value="{{ $asetLancar->unit_of_measure }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Batas Reorder <span class="text-danger">*</span></label>
                            <input type="number" name="reorder_level" class="form-control" value="{{ $asetLancar->reorder_level }}" min="0" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Harga Satuan (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="unit_price" class="form-control" value="{{ $asetLancar->unit_price }}" min="0" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Kadaluarsa</label>
                            <input type="date" name="expiry_date" class="form-control" value="{{ $asetLancar->expiry_date ? $asetLancar->expiry_date->format('Y-m-d') : '' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Foto</label>
                            @if($asetLancar->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $asetLancar->photo) }}" width="100">
                                </div>
                            @endif
                            <input type="file" name="photo" class="form-control-file" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="notes" class="form-control" rows="3">{{ $asetLancar->notes }}</textarea>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{ route('aset-lancar.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </div>
    </form>
@stop
