@extends('adminlte::page')

@section('title', 'Usulan Pemanfaatan & Pemindahtanganan')

@section('content_header')
    <h1>Usulan Pemanfaatan & Pemindahtanganan</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Usulan Aksi Aset</h3>
            <div class="card-tools">
                <a href="{{ route('rkbmn.actions.create') }}" class="btn btn-primary btn-sm">
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
                        <th>Aset</th>
                        <th>Jenis Usulan</th>
                        <th>Estimasi Penerimaan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($actions as $index => $item)
                        <tr>
                            <td>{{ $actions->firstItem() + $index }}</td>
                            <td>{{ $item->year }}</td>
                            <td>{{ $item->asset->nama_barang ?? 'N/A' }} <br> <small>{{ $item->asset->kode_barang ?? '-' }}</small></td>
                            <td>{{ $item->action_type }}</td>
                            <td class="text-right">Rp {{ number_format($item->estimated_revenue, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-secondary">{{ ucfirst($item->status) }}</span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('rkbmn.actions.show', $item) }}" class="btn btn-info btn-xs" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('rkbmn.actions.edit', $item) }}" class="btn btn-warning btn-xs" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('rkbmn.actions.destroy', $item) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus usulan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada usulan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $actions->links() }}
            </div>
        </div>
    </div>
@stop
