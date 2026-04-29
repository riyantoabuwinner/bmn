@extends('adminlte::page')

@section('title', 'Peminjaman Aset')

@section('content_header')
    <h1>Manajemen Peminjaman Aset</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Peminjaman</h3>
            <div class="card-tools">
                <a href="{{ route('borrowings.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Ajukan Peminjaman
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="borrowingsTable" class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Aset</th>
                        <th>Peminjam</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrowings as $borrowing)
                        <tr>
                            <td>{{ $borrowing->id }}</td>
                            <td>
                                <strong>{{ $borrowing->asset->kode_barang }}</strong><br>
                                <small>{{ $borrowing->asset->nama_barang }}</small>
                            </td>
                            <td>
                                {{ $borrowing->borrower_name }}<br>
                                <small class="text-muted">{{ $borrowing->borrower_phone }}</small>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($borrowing->return_date)->format('d/m/Y') }}</td>
                            <td>
                                @if($borrowing->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($borrowing->status == 'approved')
                                    @if($borrowing->returned_at)
                                        <span class="badge badge-success">Dikembalikan</span>
                                    @else
                                        <span class="badge badge-info">Aktif</span>
                                    @endif
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('borrowings.show', $borrowing) }}" class="btn btn-info btn-xs" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($borrowing->status == 'pending')
                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#approveModal{{ $borrowing->id }}" title="Setujui">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#rejectModal{{ $borrowing->id }}" title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif

                                @if($borrowing->status == 'approved' && !$borrowing->returned_at)
                                    <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" class="d-inline" onsubmit="return confirm('Konfirmasi pengembalian aset?')">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-xs" title="Kembalikan">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>

                        {{-- Approve Modal --}}
                        <div class="modal fade" id="approveModal{{ $borrowing->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Setujui Peminjaman</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form action="{{ route('borrowings.approve', $borrowing) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <p>Yakin ingin menyetujui peminjaman aset <strong>{{ $borrowing->asset->nama_barang }}</strong> oleh <strong>{{ $borrowing->borrower_name }}</strong>?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Setujui</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Reject Modal --}}
                        <div class="modal fade" id="rejectModal{{ $borrowing->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Tolak Peminjaman</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form action="{{ route('borrowings.reject', $borrowing) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <p>Alasan penolakan untuk peminjaman <strong>{{ $borrowing->asset->nama_barang }}</strong>:</p>
                                            <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $borrowings->links() }}
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#borrowingsTable').DataTable({
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
