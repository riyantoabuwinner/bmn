@extends('adminlte::page')

@section('title', 'Evaluasi Kinerja Aset (SBSK)')

@section('content_header')
    <h1>Evaluasi Kinerja Aset (SBSK)</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Portofolio Aset</h3>
            <div class="card-tools">
                <a href="{{ route('performances.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Evaluasi Baru
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Asset</th>
                        <th>Kategori</th>
                        <th>Target SBSK</th>
                        <th>Kondisi Eksisting</th>
                        <th>Efisiensi (%)</th>
                        <th>Status</th>
                        <th>Tanggal Evaluasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($performances as $performance)
                        <tr>
                            <td>
                                {{ $performance->asset->nama_barang }} <br>
                                <small class="text-muted">{{ $performance->asset->kode_barang }}</small>
                            </td>
                            <td>{{ $performance->category }}</td>
                            <td>{{ number_format($performance->sbsk_target, 2) }}</td>
                            <td>{{ number_format($performance->actual_usage, 2) }}</td>
                            <td>
                                <span class="font-weight-bold {{ $performance->efficiency_ratio > 100 ? 'text-danger' : 'text-success' }}">
                                    {{ number_format($performance->efficiency_ratio, 2) }}%
                                </span>
                            </td>
                            <td>
                                @if($performance->status == 'Optimal')
                                    <span class="badge badge-success">Optimal</span>
                                @elseif($performance->status == 'Underutilized')
                                    <span class="badge badge-warning">Underutilized</span>
                                @else
                                    <span class="badge badge-danger">Overutilized</span>
                                @endif
                            </td>
                            <td>{{ $performance->evaluation_date->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('performances.show', $performance) }}" class="btn btn-xs btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('performances.edit', $performance) }}" class="btn btn-xs btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('performances.destroy', $performance) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data evaluasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data evaluasi kinerja.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
