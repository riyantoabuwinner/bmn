@extends('adminlte::page')

@section('title', 'Jenis Aset Lancar/ Persediaan')

@section('content_header')
    <h1>Jenis Aset Lancar/ Persediaan</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Kategori Aset Lancar (Standar BMN)</h3>
            <div class="card-tools">
                <a href="{{ route('current-asset-categories.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Kategori
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> 
                Kategori aset lancar/persediaan ini disesuaikan dengan standar akuntansi pemerintahan (Barang Konsumsi, Suku Cadang, dll).
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="30%">Jenis Aset Lancar</th>
                            <th>Deskripsi</th>
                            <th width="15%">Jumlah Item</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $category->name }}</strong></td>
                                <td>{{ $category->description }}</td>
                                <td>
                                    <a href="{{ route('current-assets.index', ['category_id' => $category->id]) }}" class="badge badge-info value-clickable" title="Lihat daftar aset">
                                        {{ $category->current_assets_count }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('current-asset-categories.edit', $category->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('current-asset-categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-light font-weight-bold">
                            <td colspan="3" class="text-right">Total Item Aset:</td>
                            <td colspan="2">{{ $categories->sum('current_assets_count') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@stop
