@extends('adminlte::page')

@section('title', 'Tambah Kategori Aset Lancar')

@section('content_header')
    <h1>Tambah Kategori Aset Lancar</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Kategori</h3>
        </div>
        <form action="{{ route('current-asset-categories.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Persediaan Barang Konsumsi" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi kategori..."></textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('current-asset-categories.index') }}" class="btn btn-default">Kembali</a>
            </div>
        </form>
    </div>
@stop
