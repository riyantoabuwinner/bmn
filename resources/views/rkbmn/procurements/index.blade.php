@extends('adminlte::page')

@section('title', 'Usulan Pengadaan')

@section('content_header')
    <h1>Usulan Pengadaan RKBMN</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Usulan Pengadaan Aset Baru</h3>
            <div class="card-tools">
                <a href="{{ route('rkbmn.procurements.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Usulan
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun</th>
                        <th>Nama Barang</th>
                        <th>Jenis</th>
                        <th>Volume</th>
                        <th>Estimasi Biaya</th>
                        <th>Prioritas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($procurements as $index => $item)
                        <tr>
                            <td>{{ $procurements->firstItem() + $index }}</td>
                            <td>{{ $item->year }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->quantity }} {{ $item->unit }}</td>
                            <td class="text-right">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-{{ $item->priority == 'Tinggi' ? 'danger' : ($item->priority == 'Sedang' ? 'warning' : 'success') }}">
                                    {{ $item->priority }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('rkbmn.procurements.show', $item) }}" class="btn btn-info btn-xs" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('rkbmn.procurements.edit', $item) }}" class="btn btn-warning btn-xs" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('rkbmn.procurements.destroy', $item) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus usulan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada usulan pengadaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $procurements->links() }}
            </div>
        </div>
    </div>
@stop
