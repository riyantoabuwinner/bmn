@extends('adminlte::page')

@section('title', 'Daftar Evaluasi Aset')

@section('content_header')
    <h1>Evaluasi Aset Berkala</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Periode Evaluasi</h3>
            <div class="card-tools">
                <a href="{{ route('evaluations.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Mulai Evaluasi Baru
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Periode</th>
                        <th>Tipe</th>
                        <th>Dibuat Oleh</th>
                        <th>Status</th>
                        <th>Tanggal Finalisasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($evaluations as $eval)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $eval->period_name }}</td>
                            <td>
                                @if($eval->period_type == 'semester')
                                    <span class="badge badge-info">Semester</span>
                                @else
                                    <span class="badge badge-primary">Tahunan</span>
                                @endif
                            </td>
                            <td>{{ $eval->creator->name ?? '-' }}</td>
                            <td>
                                @if($eval->status == 'draft')
                                    <span class="badge badge-warning">Draft (Sedang Berjalan)</span>
                                @else
                                    <span class="badge badge-success">Selesai (Final)</span>
                                @endif
                            </td>
                            <td>{{ $eval->finalized_at ? $eval->finalized_at->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($eval->status == 'draft')
                                    <a href="{{ route('evaluations.edit', $eval) }}" class="btn btn-xs btn-warning">
                                        <i class="fas fa-edit"></i> Input Hasil
                                    </a>
                                @else
                                    <a href="{{ route('evaluations.show', $eval) }}" class="btn btn-xs btn-info">
                                        <i class="fas fa-eye"></i> Lihat Laporan
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada periode evaluasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $evaluations->links() }}
            </div>
        </div>
    </div>
@stop
