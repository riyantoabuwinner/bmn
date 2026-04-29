@extends('adminlte::page')

@section('title', 'Distribusi Aset')

@section('content_header')
    <h1>Distribusi Aset</h1>
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
            <h3 class="card-title">Riwayat Distribusi</h3>
            <div class="card-tools">
                <a href="{{ route('distributions.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Distribusi
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="distributionsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Aset</th>
                        <th>Unit Tujuan</th>
                        <th>Penerima</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($distributions as $dist)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($dist->distribution_date)->format('d/m/Y') }}</td>
                            <td>
                                <strong>{{ $dist->asset->kode_barang }}</strong><br>
                                <small>{{ $dist->asset->nama_barang }}</small>
                            </td>
                            <td>{{ $dist->unit->name }}</td>
                            <td>{{ $dist->recipient_name }}</td>
                            <td>{{ $dist->recipient_position }}</td>
                            <td>
                                <form action="{{ route('distributions.destroy', $dist) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data distribusi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $distributions->links() }}
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#distributionsTable').DataTable({
                responsive: true,
                paging: false,
                searching: true,
                info: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                }
            });
        });
    </script>
@stop
