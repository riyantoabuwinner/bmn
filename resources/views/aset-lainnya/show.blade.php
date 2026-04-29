@extends('adminlte::page')

@section('title', 'Detail Aset Lainnya')

@section('content_header')
    <h1>Detail Aset Lainnya</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $asetLainnya->name }}</h3>
            <div class="card-tools">
                <a href="{{ route('aset-lainnya.edit', $asetLainnya) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Kode Aset</th>
                    <td><strong>{{ $asetLainnya->asset_code }}</strong></td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $asetLainnya->name }}</td>
                </tr>
                <tr>
                    <th>Tipe Aset</th>
                    <td>
                        @if($asetLainnya->asset_type == 'lisensi')
                            <span class="badge badge-info">Lisensi</span>
                        @elseif($asetLainnya->asset_type == 'paten')
                            <span class="badge badge-success">Paten</span>
                        @elseif($asetLainnya->asset_type == 'hak_cipta')
                            <span class="badge badge-primary">Hak Cipta</span>
                        @elseif($asetLainnya->asset_type == 'hak_sewa')
                            <span class="badge badge-warning">Hak Sewa</span>
                        @else
                            <span class="badge badge-secondary">Lainnya</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $asetLainnya->category->name }}</td>
                </tr>
                <tr>
                    <th>Unit Pemilik</th>
                    <td>{{ $asetLainnya->unit->name }}</td>
                </tr>
                <tr>
                    <th>Lokasi</th>
                    <td>{{ $asetLainnya->location->name }}</td>
                </tr>
                <tr>
                    <th>Nilai Perolehan</th>
                    <td>Rp {{ number_format($asetLainnya->purchase_value, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Nilai Saat Ini</th>
                    <td><strong>Rp {{ number_format($asetLainnya->current_value, 0, ',', '.') }}</strong></td>
                </tr>
                <tr>
                    <th>Tanggal Perolehan</th>
                    <td>{{ $asetLainnya->purchase_date->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Berlaku Dari</th>
                    <td>{{ $asetLainnya->start_date ? $asetLainnya->start_date->format('d/m/Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Berlaku Sampai</th>
                    <td>
                        @if($asetLainnya->end_date)
                            {{ $asetLainnya->end_date->format('d/m/Y') }}
                            @if($asetLainnya->isExpired())
                                <span class="badge badge-danger ml-2">Kadaluarsa!</span>
                            @endif
                        @else
                            <em class="text-muted">Tidak terbatas</em>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($asetLainnya->status == 'active')
                            <span class="badge badge-success">Aktif</span>
                        @elseif($asetLainnya->status == 'inactive')
                            <span class="badge badge-secondary">Tidak Aktif</span>
                        @else
                            <span class="badge badge-danger">Kadaluarsa</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $asetLainnya->description ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Catatan</th>
                    <td>{{ $asetLainnya->notes ?? '-' }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('aset-lainnya.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('aset-lainnya.edit', $asetLainnya) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('aset-lainnya.destroy', $asetLainnya) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
@stop
