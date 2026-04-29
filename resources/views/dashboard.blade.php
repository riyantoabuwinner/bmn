@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="text-center font-weight-bold">Dashboard BMN System</h1>
@stop

@section('content')
    @if(app('impersonate')->isImpersonating())
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fas fa-user-secret"></i> Mode Penyamaran Aktif!</h4>
            Anda sedang login sebagai <strong>{{ auth()->user()->name }}</strong>.
            <a href="{{ route('impersonate.leave') }}" class="btn btn-outline-dark btn-sm text-decoration-none ml-2">
                <i class="fas fa-sign-out-alt"></i> Keluar Mode Penyamaran
            </a>
        </div>
    @endif

    <h4 class="mb-3">Manajemen Aset Tetap</h4>
    <div class="row">
        <!-- Main Stats -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ number_format($stats['total_assets'], 0, ',', '.') }}</h3>
                    <p>Total Aset Tetap</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <a href="{{ route('assets.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($stats['available_assets'], 0, ',', '.') }}</h3>
                    <p>Aset Operasional (Digunakan)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{ route('assets.index', ['status' => 'Digunakan']) }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($stats['maintenance_assets'], 0, ',', '.') }}</h3>
                    <p>Dalam Pemeliharaan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tools"></i>
                </div>
                <a href="{{ route('assets.index', ['status' => 'Dalam Pemeliharaan']) }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ number_format($stats['condition_rb'], 0, ',', '.') }}</h3>
                    <p>Rusak Berat</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <a href="{{ route('assets.index', ['kondisi' => 'Rusak Berat']) }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Condition Breakdown & Management Status -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i> Kondisi Fisik Aset Tetap</h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4 border-right">
                            <h4 class="text-success font-weight-bold">{{ $stats['condition_baik'] }}</h4>
                            <span class="text-muted">Baik</span>
                        </div>
                        <div class="col-4 border-right">
                            <h4 class="text-warning font-weight-bold">{{ $stats['condition_rr'] }}</h4>
                            <span class="text-muted">Rusak Ringan</span>
                        </div>
                        <div class="col-4">
                            <h4 class="text-danger font-weight-bold">{{ $stats['condition_rb'] }}</h4>
                            <span class="text-muted">Rusak Berat</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Aset Tetap Terbaru</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Merk/Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_assets as $asset)
                                <tr>
                                    <td><strong>{{ $asset->kode_barang }}</strong></td>
                                    <td>{{ Str::limit($asset->nama_barang, 25) }}</td>
                                    <td>{{ $asset->merk_type ?? '-' }}</td>
                                    <td>
                                        @if($asset->status_pemanfaatan == 'Digunakan')
                                            <span class="badge badge-success">Digunakan</span>
                                        @elseif($asset->status_pemanfaatan == 'Dipinjam')
                                            <span class="badge badge-warning">Dipinjam</span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($asset->status_pemanfaatan ?? 'N/A') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data aset</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-tasks mr-1"></i> Status Pengelolaan BMN</h3>
                </div>
                <div class="card-body">
                    <div class="progress-group">
                        Penetapan Status (PSP)
                        <span class="float-right"><b>{{ $stats['psp_count'] }}</b>/{{ $stats['total_assets'] }}</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: {{ $stats['psp_percentage'] }}%"></div>
                        </div>
                    </div>

                    <div class="progress-group mt-3">
                        Asuransi BMN (Aktif)
                        <span class="float-right"><b>{{ $stats['insurance_count'] }}</b>/{{ $stats['total_assets'] }}</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: {{ $stats['insurance_percentage'] }}%"></div>
                        </div>
                    </div>

                    <div class="progress-group mt-3">
                        Evaluasi Kinerja (SBSK)
                        <span class="float-right"><b>{{ $stats['performance_count'] }}</b>/{{ $stats['total_assets'] }}</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info" style="width: {{ $stats['performance_percentage'] }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <small class="text-muted"><i class="fas fa-info-circle"></i> Persentase cakupan pengelolaan aset tetap</small>
                </div>
            </div>

            <div class="info-box shadow-none border">
                <span class="info-box-icon bg-indigo"><i class="fas fa-hand-holding-usd"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Nilai Perolehan Aset Tetap</span>
                    <span class="info-box-number" style="font-size: 1.4rem">
                        Rp {{ number_format($stats['total_value'], 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <h4 class="mb-4">Manajemen Aset Lancar / Persediaan</h4>

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-info">
                <div class="inner">
                    <h3>{{ number_format($stats['total_current_assets'], 0, ',', '.') }}</h3>
                    <p>Total Stok Tersedia</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cubes"></i>
                </div>
                <a href="{{ route('current-assets.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-warning">
                <div class="inner">
                    <h3>{{ $stats['low_stock_count'] }}</h3>
                    <p>Stok Rendah / Habis</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <a href="{{ route('current-assets.index', ['low_stock' => '1']) }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-teal">
                <div class="inner">
                    <h3>{{ $stats['total_current_types'] }}</h3>
                    <p>Jenis Barang</p>
                </div>
                <div class="icon">
                    <i class="fas fa-th-list"></i>
                </div>
                <a href="{{ route('current-asset-categories.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-maroon">
                <div class="inner">
                    <h3 style="font-size: 1.5rem">Rp {{ number_format($stats['total_current_value'], 0, ',', '.') }}</h3>
                    <p>Total Nilai Persediaan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <a href="{{ route('current-assets.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Aset Lancar Terbaru</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Stok</th>
                                    <th>Satuan</th>
                                    <th>Nilai Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_current_assets as $asset)
                                    <tr>
                                        <td><strong>{{ $asset->kode_barang }}</strong></td>
                                        <td>{{ $asset->nama_barang }}</td>
                                        <td>{{ number_format($asset->stok_tersedia, 0, ',', '.') }}</td>
                                        <td>{{ $asset->satuan }}</td>
                                        <td>Rp {{ number_format($asset->nilai_total, 0, ',', '.') }}</td>
                                        <td>
                                            @if($asset->stok_tersedia <= $asset->stok_minimum)
                                                <span class="badge badge-danger">Stok Rendah</span>
                                            @else
                                                <span class="badge badge-success">Aman</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Belum ada data aset lancar</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ringkasan Nilai Seluruh BMN</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-university"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Nilai Aset Tetap</span>
                                    <span class="info-box-number">Rp {{ number_format($stats['total_value'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-teal">
                                <span class="info-box-icon"><i class="fas fa-store"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Nilai Aset Lancar / Persediaan</span>
                                    <span class="info-box-number">Rp {{ number_format($stats['total_current_value'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-box bg-gradient-purple">
                        <span class="info-box-icon"><i class="fas fa-money-check-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Kekayaan BMN (Tetap + Lancar)</span>
                            <span class="info-box-number" style="font-size: 1.8rem">
                                Rp {{ number_format($stats['total_value'] + $stats['total_current_value'], 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
