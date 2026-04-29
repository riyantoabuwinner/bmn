@extends('adminlte::page')

@section('title', 'Asuransi BMN')

@section('content_header')
    <h1>Daftar Asuransi BMN</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Pertanggungan Asuransi</h3>
            <div class="card-tools">
                <a href="{{ route('insurances.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Daftar Objek Asuransi
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Asset</th>
                        <th>No Polis</th>
                        <th>Perusahaan</th>
                        <th>Masa Berlaku</th>
                        <th>Nilai Pertanggungan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($insurances as $insurance)
                        <tr>
                            <td>
                                {{ $insurance->asset->nama_barang }} <br>
                                <small class="text-muted">{{ $insurance->asset->kode_barang }}</small>
                            </td>
                            <td>{{ $insurance->policy_number ?? '-' }}</td>
                            <td>{{ $insurance->insurance_company ?? '-' }}</td>
                            <td>
                                @if($insurance->start_date && $insurance->end_date)
                                    {{ $insurance->start_date->format('d/m/Y') }} - {{ $insurance->end_date->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>Rp {{ number_format($insurance->coverage_amount, 0, ',', '.') }}</td>
                            <td>
                                @if($insurance->status == 'Aktif')
                                    <span class="badge badge-success">Aktif</span>
                                @elseif($insurance->status == 'Usulan')
                                    <span class="badge badge-info">Usulan</span>
                                @else
                                    <span class="badge badge-danger">Berakhir</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('insurances.show', $insurance) }}" class="btn btn-xs btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('insurances.edit', $insurance) }}" class="btn btn-xs btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('insurances.destroy', $insurance) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data asuransi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data asuransi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
