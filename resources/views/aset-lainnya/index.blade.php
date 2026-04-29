@extends('adminlte::page')

@section('title', 'Aset Lainnya')

@section('content_header')
    <h1>Manajemen Aset Lainnya</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Aset Lainnya (Intangible Assets)</h3>
            <div class="card-tools">
                <a href="{{ route('aset-lainnya.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Aset Lainnya
                </a>
            </div>
        </div>
        
        {{-- Filter Section --}}
        <div class="card-body border-bottom">
            <form method="GET" action="{{ route('aset-lainnya.index') }}" class="form-inline">
                <div class="form-group mr-2">
                    <select name="category_id" class="form-control form-control-sm">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mr-2">
                    <select name="asset_type" class="form-control form-control-sm">
                        <option value="">Semua Tipe</option>
                        <option value="lisensi" {{ request('asset_type') == 'lisensi' ? 'selected' : '' }}>Lisensi</option>
                        <option value="paten" {{ request('asset_type') == 'paten' ? 'selected' : '' }}>Paten</option>
                        <option value="hak_cipta" {{ request('asset_type') == 'hak_cipta' ? 'selected' : '' }}>Hak Cipta</option>
                        <option value="hak_sewa" {{ request('asset_type') == 'hak_sewa' ? 'selected' : '' }}>Hak Sewa</option>
                        <option value="lainnya" {{ request('asset_type') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <select name="status" class="form-control form-control-sm">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm mr-2"><i class="fas fa-search"></i> Filter</button>
                <a href="{{ route('aset-lainnya.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i> Reset</a>
            </form>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Kategori</th>
                        <th>Nilai</th>
                        <th>Berlaku s/d</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assets as $asset)
                        <tr class="{{ $asset->isExpired() ? 'table-danger' : '' }}">
                            <td><strong>{{ $asset->asset_code }}</strong></td>
                            <td>{{ $asset->name }}</td>
                            <td>
                                @if($asset->asset_type == 'lisensi')
                                    <span class="badge badge-info">Lisensi</span>
                                @elseif($asset->asset_type == 'paten')
                                    <span class="badge badge-success">Paten</span>
                                @elseif($asset->asset_type == 'hak_cipta')
                                    <span class="badge badge-primary">Hak Cipta</span>
                                @elseif($asset->asset_type == 'hak_sewa')
                                    <span class="badge badge-warning">Hak Sewa</span>
                                @else
                                    <span class="badge badge-secondary">Lainnya</span>
                                @endif
                            </td>
                            <td>{{ $asset->category->name }}</td>
                            <td class="text-right">Rp {{ number_format($asset->current_value, 0, ',', '.') }}</td>
                            <td>
                                @if($asset->end_date)
                                    {{ $asset->end_date->format('d/m/Y') }}
                                    @if($asset->isExpired())
                                        <span class="badge badge-danger">Expired</span>
                                    @endif
                                @else
                                    <em class="text-muted">-</em>
                                @endif
                            </td>
                            <td>
                                @if($asset->status == 'active')
                                    <span class="badge badge-success">Aktif</span>
                                @elseif($asset->status == 'inactive')
                                    <span class="badge badge-secondary">Tidak Aktif</span>
                                @else
                                    <span class="badge badge-danger">Kadaluarsa</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('aset-lainnya.show', $asset) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('aset-lainnya.edit', $asset) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('aset-lainnya.destroy', $asset) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $assets->links() }}
            </div>
        </div>
    </div>
@stop
