@extends('adminlte::page')

@section('title', 'Maintenance Aset')

@section('content_header')
    <h1>Maintenance Aset</h1>
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
            <h3 class="card-title">Jadwal Maintenance</h3>
            <div class="card-tools">
                <a href="{{ route('maintenances.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Jadwalkan Maintenance
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="maintenancesTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Tanggal Jadwal</th>
                        <th>Aset</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Biaya Estimasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($maintenances as $mt)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($mt->scheduled_date)->format('d/m/Y') }}</td>
                            <td>
                                <strong>{{ $mt->asset->kode_barang }}</strong><br>
                                <small>{{ $mt->asset->nama_barang }}</small>
                            </td>
                            <td>{{ ucfirst($mt->maintenance_type) }}</td>
                            <td>
                                @if($mt->status == 'dijadwalkan')
                                    <span class="badge badge-warning">Dijadwalkan</span>
                                @elseif($mt->status == 'dalam_proses')
                                    <span class="badge badge-info">Dalam Proses</span>
                                @elseif($mt->status == 'selesai')
                                    <span class="badge badge-success">Selesai</span>
                                @else
                                    <span class="badge badge-secondary">Dibatalkan</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($mt->estimated_cost, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('maintenances.show', $mt) }}" class="btn btn-info btn-xs" title="Select">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($mt->status != 'selesai' && $mt->status != 'dibatalkan')
                                    <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#completeModal{{ $mt->id }}" title="Selesaikan">
                                        <i class="fas fa-check"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>

                        <!-- Complete Modal -->
                        @if($mt->status != 'selesai')
                        <div class="modal fade" id="completeModal{{ $mt->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('maintenances.update', $mt) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="selesai">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Selesaikan Maintenance</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Kondisi Aset Sekarang</label>
                                                <select name="condition_after" class="form-control" required>
                                                    <option value="baik">Baik</option>
                                                    <option value="rusak_ringan">Rusak Ringan</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Biaya Aktual (Rp)</label>
                                                <input type="number" name="actual_cost" class="form-control" value="{{ $mt->estimated_cost }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Catatan Penyelesaian</label>
                                                <textarea name="completion_notes" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#maintenancesTable').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                }
            });
        });
    </script>
@stop
