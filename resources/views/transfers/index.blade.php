@extends('adminlte::page')

@section('title', 'Daftar Pemindahtanganan')

@section('content_header')
    <h1>Daftar Pemindahtanganan Aset</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Pemindahtanganan</h3>
            <div class="card-tools">
                <a href="{{ route('transfers.create') }}" class="btn btn-primary btn-sm">
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
                        <th>Jenis</th>
                        <th>Penerima</th>
                        <th>No SK</th>
                        <th>Tanggal SK</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transfers as $transfer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transfer->asset->nama_barang }} ({{ $transfer->asset->kode_barang }})</td>
                            <td>{{ $transfer->transfer_type }}</td>
                            <td>{{ $transfer->recipient_name }}</td>
                            <td>{{ $transfer->sk_number }}</td>
                            <td>{{ $transfer->sk_date->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('transfers.show', $transfer->id) }}" class="btn btn-info btn-xs">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('transfers.edit', $transfer->id) }}" class="btn btn-warning btn-xs">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('transfers.destroy', $transfer->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data pemindahtanganan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $transfers->links() }}
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
