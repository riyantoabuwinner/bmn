@extends('adminlte::page')

@section('title', 'Daftar PSP')

@section('content_header')
    <h1>Penetapan Status Penggunaan (PSP)</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Dokumen PSP</h3>
            <div class="card-tools">
                <a href="{{ route('psp.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Rekam PSP Baru
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
                        <th>Nomor SK</th>
                        <th>Tanggal SK</th>
                        <th>Aset Terkait</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($psp_documents as $index => $psp)
                        <tr>
                            <td>{{ $psp_documents->firstItem() + $index }}</td>
                            <td>{{ $psp->sk_number }}</td>
                            <td>{{ $psp->sk_date->format('d M Y') }}</td>
                            <td>{{ $psp->asset->nama_barang ?? 'N/A' }} ({{ $psp->asset->kode_barang ?? '-' }})</td>
                            <td>
                                <span class="badge badge-{{ $psp->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($psp->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('psp.show', $psp) }}" class="btn btn-info btn-xs">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('psp.edit', $psp) }}" class="btn btn-warning btn-xs">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('psp.destroy', $psp) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data PSP.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $psp_documents->links() }}
            </div>
        </div>
    </div>
@stop
