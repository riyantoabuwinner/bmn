@extends('adminlte::page')

@section('title', 'Tambah Unit')

@section('content_header')
    <h1>Tambah Unit Baru</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('units.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Unit <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type">Tipe Unit <span class="text-danger">*</span></label>
                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="rektorat" {{ old('type') == 'rektorat' ? 'selected' : '' }}>Rektorat</option>
                        <option value="fakultas" {{ old('type') == 'fakultas' ? 'selected' : '' }}>Fakultas</option>
                        <option value="unit_kerja" {{ old('type') == 'unit_kerja' ? 'selected' : '' }}>Unit Kerja</option>
                    </select>
                    @error('type')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="parent_id">Unit Induk</label>
                    <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                        <option value="">-- Tidak Ada (Root) --</option>
                        @foreach($parentUnits as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }} ({{ ucfirst($parent->type) }})
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <small class="form-text text-muted">Opsional. Pilih unit induk jika ini adalah sub-unit.</small>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('units.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
@stop
