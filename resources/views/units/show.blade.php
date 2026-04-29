@extends('adminlte::page')

@section('title', 'Detail Unit')

@section('content_header')
    <h1>Detail Unit</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Unit</h3>
                    <div class="card-tools">
                        <a href="{{ route('units.edit', $unit) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Nama</th>
                            <td>{{ $unit->name }}</td>
                        </tr>
                        <tr>
                            <th>Tipe</th>
                            <td>
                                @if($unit->type == 'rektorat')
                                    <span class="badge badge-primary">Rektorat</span>
                                @elseif($unit->type == 'fakultas')
                                    <span class="badge badge-info">Fakultas</span>
                                @else
                                    <span class="badge badge-secondary">Unit Kerja</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Unit Induk</th>
                            <td>{{ $unit->parent->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $unit->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Statistik</h3>
                </div>
                <div class="card-body">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-sitemap"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Sub-Unit</span>
                            <span class="info-box-number">{{ $unit->children->count() }}</span>
                        </div>
                    </div>

                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pengguna</span>
                            <span class="info-box-number">{{ $unit->users->count() }}</span>
                        </div>
                    </div>

                    <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-boxes"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Aset</span>
                            <span class="info-box-number">{{ $unit->assets->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($unit->children->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sub-Unit</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($unit->children as $child)
                            <tr>
                                <td>{{ $child->name }}</td>
                                <td>
                                    @if($child->type == 'fakultas')
                                        <span class="badge badge-info">Fakultas</span>
                                    @else
                                        <span class="badge badge-secondary">Unit Kerja</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('units.show', $child) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <a href="{{ route('units.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@stop
