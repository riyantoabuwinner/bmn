@extends('adminlte::page')

@section('title', 'Aset Lancar')

@section('content_header')
    <h1>Manajemen Aset Lancar</h1>
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
            <h3 class="card-title">Daftar Aset Lancar (Persediaan)</h3>
            <div class="card-tools">
                <a href="{{ route('aset-lancar.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Aset Lancar
                </a>
            </div>
        </div>
        
        {{-- Filter Section --}}
        <div class="card-body border-bottom">
            <div class="accordion" id="filterAccordion">
                <div class="card">
                    <div class="card-header p-2" id="filterHeading">
                        <h5 class="mb-0">
                            <button class="btn btn-link btn-sm" type="button" data-toggle="collapse" data-target="#filterCollapse" aria-expanded="false">
                                <i class="fas fa-filter"></i> Filter Aset
                                @if(request()->hasAny(['category_id', 'unit_id', 'location_id', 'condition_status', 'search', 'low_stock', 'expired']))
                                    <span class="badge badge-primary">Aktif</span>
                                @endif
                            </button>
                        </h5>
                    </div>

                    <div id="filterCollapse" class="collapse {{ request()->hasAny(['category_id', 'unit_id', 'location_id', 'condition_status', 'search', 'low_stock', 'expired']) ? 'show':'' }}"  data-parent="#filterAccordion">
                        <div class="card-body">
                            <form method="GET" action="{{ route('aset-lancar.index') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <select name="category_id" class="form-control form-control-sm">
                                                <option value="">Semua Kategori</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Unit</label>
                                            <select name="unit_id" class="form-control form-control-sm">
                                                <option value="">Semua Unit</option>
                                                @foreach($units as $unit)
                                                    <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                                                        {{ $unit->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Lokasi</label>
                                            <select name="location_id" class="form-control form-control-sm">
                                                <option value="">Semua Lokasi</option>
                                                @foreach($locations as $location)
                                                    <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                                                        {{ $location->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Kondisi</label>
                                            <select name="condition_status" class="form-control form-control-sm">
                                                <option value="">Semua Kondisi</option>
                                                <option value="baik" {{ request('condition_status') == 'baik' ? 'selected' : '' }}>Baik</option>
                                                <option value="rusak" {{ request('condition_status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Pencarian</label>
                                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama aset..." value="{{ request('search') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="d-block">Stok Menipis</label>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="lowStock" name="low_stock" value="1" {{ request('low_stock') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="lowStock">Tampilkan</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="d-block">Kadaluarsa</label>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="expired" name="expired" value="1" {{ request('expired') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="expired">Tampilkan</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="d-block">&nbsp;</label>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-search"></i> Terapkan Filter
                                            </button>
                                            <a href="{{ route('aset-lancar.index') }}" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-times"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table id="assetsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Nilai Total</th>
                        <th>Kondisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assets as $asset)
                        <tr class="{{ $asset->isLowStock() ? 'table-warning' : '' }} {{ $asset->isExpired() ? 'table-danger' : '' }}">
                            <td><strong>{{ $asset->asset_code }}</strong></td>
                            <td>
                                @if($asset->photo)
                                    <img src="{{ asset('storage/' . $asset->photo) }}" width="30" class="mr-2">
                                @endif
                                {{ $asset->name }}
                                @if($asset->isLowStock())
                                    <span class="badge badge-warning ml-1">Stok Menipis</span>
                                @endif
                                @if($asset->isExpired())
                                    <span class="badge badge-danger ml-1">Kadaluarsa</span>
                                @endif
                            </td>
                            <td>{{ $asset->category->name }}</td>
                            <td class="text-right">
                                <strong>{{ number_format($asset->quantity) }}</strong>
                                @if($asset->isLowStock())
                                    / <span class="text-danger">{{ $asset->reorder_level }}</span>
                                @endif
                            </td>
                            <td>{{ $asset->unit_of_measure }}</td>
                            <td class="text-right">Rp {{ number_format($asset->total_value, 0, ',', '.') }}</td>
                            <td>
                                @if($asset->condition_status == 'baik')
                                    <span class="badge badge-success">Baik</span>
                                @else
                                    <span class="badge badge-danger">Rusak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('aset-lancar.show', $asset) }}" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('aset-lancar.edit', $asset) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('aset-lancar.destroy', $asset) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
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

@section('js')
    <script>
        $(document).ready(function() {
            $('#assetsTable').DataTable({
                responsive: true,
                paging: false,
                searching: false,
                info: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                }
            });
        });
    </script>
@stop
