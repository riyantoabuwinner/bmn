@extends('adminlte::page')

@section('title', 'Edit Kategori Aset Lancar')

@section('content_header')
    <h1>Edit Kategori Aset Lancar</h1>
@stop

@section('content')
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Form Edit Kategori</h3>
        </div>
        <form action="{{ route('current-asset-categories.update', $currentAssetCategory->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="name" class="form-control" value="{{ $currentAssetCategory->name }}" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ $currentAssetCategory->description }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('current-asset-categories.index') }}" class="btn btn-default">Kembali</a>
            </div>
        </form>
    </div>
@stop
