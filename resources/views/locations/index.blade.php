@extends('adminlte::page')

@section('title', 'Lokasi Aset')

@section( 'content_header')
    <h1>Manajemen Lokasi Aset</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Lokasi</h3>
            <div class="card-tools">
                <a href="{{ route('locations.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Lokasi
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="locationsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama Lokasi</th>
                        <th>Unit</th>
                        <th>Jumlah Aset</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($locations as $location)
                        <tr>
                            <td>{{ $location->name }}</td>
                            <td>{{ $location->unit->name }}</td>
                            <td><span class="badge badge-info">{{ $location->assets_count }}</span></td>
                            <td>
                                <a href="{{ route('locations.edit', $location) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('locations.destroy', $location) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#locationsTable').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                }
            });
        });
    </script>
@stop
