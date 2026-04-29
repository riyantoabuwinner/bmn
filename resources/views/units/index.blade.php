@extends('adminlte::page')

@section('title', 'Manajemen Unit')

@section('content_header')
    <h1>Manajemen Unit</h1>
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
            <h3 class="card-title">Daftar Unit</h3>
            <div class="card-tools">
                <a href="{{ route('units.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Unit
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="unitsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Unit Induk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($units as $unit)
                        <tr>
                            <td>{{ $unit->name }}</td>
                            <td>
                                @if($unit->type == 'rektorat')
                                    <span class="badge badge-primary">Rektorat</span>
                                @elseif($unit->type == 'fakultas')
                                    <span class="badge badge-info">Fakultas</span>
                                @else
                                    <span class="badge badge-secondary">Unit Kerja</span>
                                @endif
                            </td>
                            <td>{{ $unit->parent->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('units.show', $unit) }}" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('units.edit', $unit) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('units.destroy', $unit) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus unit ini?')">
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
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#unitsTable').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                }
            });
        });
    </script>
@stop
