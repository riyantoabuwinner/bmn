@extends('adminlte::page')

@section('title', 'Daftar Penghapusan')

@section('content_header')
    <h1>Daftar Penghapusan Aset (SK Eliminasi)</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Penghapusan</h3>
            <div class="card-tools">
                <a href="{{ route('deletions.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Rekam Baru
                </a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Aset</th>
                        <th>Kondisi (Saat Dihapus)</th>
                        <th>Jenis Penghapusan</th>
                        <th>No SK</th>
                        <th>Tanggal SK</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deletions as $deletion)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $deletion->asset ? $deletion->asset->nama_barang . ' (' . $deletion->asset->kode_barang . ')' : 'Aset Tidak Ditemukan' }}
                            </td>
                            <td>{{ $deletion->asset ? $deletion->asset->kondisi : '-' }}</td>
                            <td>{{ $deletion->deletion_type }}</td>
                            <td>{{ $deletion->sk_number }}</td>
                            <td>{{ $deletion->sk_date->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('deletions.show', $deletion->id) }}" class="btn btn-info btn-xs">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('deletions.edit', $deletion->id) }}" class="btn btn-warning btn-xs">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('deletions.destroy', $deletion->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus data ini? Aset akan dikembalikan ke daftar aktif.')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data penghapusan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $deletions->links() }}
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
