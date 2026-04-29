@extends('adminlte::page')

@section('title', 'Tambah Aset Lancar')

@section('content_header')
    <h1>Tambah Aset Lancar Baru</h1>
@stop

@section('content')
    <form action="{{ route('aset-lancar.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Aset <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Pilih --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Kondisi <span class="text-danger">*</span></label>
                            <select name="condition_status" class="form-control" required>
                                <option value="baik">Baik</option>
                                <option value="rusak">Rusak</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Unit Pemilik <span class="text-danger">*</span></label>
                            <select name="unit_id" class="form-control @error('unit_id') is-invalid @enderror" required>
                                <option value="">-- Pilih --</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                            @error('unit_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Lokasi <span class="text-danger">*</span></label>
                            <select name="location_id" class="form-control @error('location_id') is-invalid @enderror" required>
                                <option value="">-- Pilih --</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                            @error('location_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Pembelian <span class="text-danger">*</span></label>
                            <input type="date" name="purchase_date" class="form-control @error('purchase_date') is-invalid @enderror" value="{{ old('purchase_date') }}" required>
                            @error('purchase_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Jumlah Stok <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}" min="0" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Satuan <span class="text-danger">*</span></label>
                            <input type="text" name="unit_of_measure" class="form-control" value="{{ old('unit_of_measure') }}" placeholder="pcs, unit, box" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Batas Reorder <span class="text-danger">*</span></label>
                            <input type="number" name="reorder_level" class="form-control" value="{{ old('reorder_level') }}" min="0" required>
                            <small class="text-muted">Minimum stok untuk peringatan</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Harga Satuan (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="unit_price" class="form-control" value="{{ old('unit_price') }}" min="0" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Kadaluarsa</label>
                            <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}">
                            <small class="text-muted">Opsional, untuk aset dengan masa kadaluarsa</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Foto</label>
                            <input type="file" name="photo" class="form-control-file" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{ route('aset-lancar.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </div>
    </form>
@stop
