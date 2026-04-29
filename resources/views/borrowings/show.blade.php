@extends('adminlte::page')

@section('title', 'Detail Peminjaman')

@section('content_header')
    <h1><i class="fas fa-handshake"></i> Detail Peminjaman Aset</h1>
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

    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Informasi Peminjaman #{{ $borrowing->id }}</h3>
                    <div class="card-tools">
                        @if($borrowing->status == 'pending')
                            <span class="badge badge-warning badge-lg">Pending</span>
                        @elseif($borrowing->status == 'approved')
                            @if($borrowing->returned_at)
                                <span class="badge badge-success badge-lg">Dikembalikan</span>
                            @else
                                <span class="badge badge-info badge-lg">Aktif (Dipinjam)</span>
                            @endif
                        @else
                            <span class="badge badge-danger badge-lg">Ditolak</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary"><i class="fas fa-box mr-2"></i>Informasi Aset</h5>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-muted" width="40%">Kode Barang</td>
                                    <td><strong>{{ $borrowing->asset->kode_barang }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Nama Barang</td>
                                    <td>{{ $borrowing->asset->nama_barang }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Merk/Type</td>
                                    <td>{{ $borrowing->asset->merk_type ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Kondisi</td>
                                    <td>
                                        @if($borrowing->asset->kondisi == 'Baik')
                                            <span class="badge badge-success">Baik</span>
                                        @elseif($borrowing->asset->kondisi == 'Rusak Ringan')
                                            <span class="badge badge-warning">Rusak Ringan</span>
                                        @else
                                            <span class="badge badge-danger">{{ $borrowing->asset->kondisi }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-primary"><i class="fas fa-user mr-2"></i>Informasi Peminjam</h5>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-muted" width="40%">Nama</td>
                                    <td><strong>{{ $borrowing->borrower_name }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Telepon</td>
                                    <td>{{ $borrowing->borrower_phone }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Email</td>
                                    <td>{{ $borrowing->borrower_email ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary"><i class="fas fa-calendar mr-2"></i>Jadwal Peminjaman</h5>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-muted" width="40%">Tanggal Pinjam</td>
                                    <td>{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tanggal Kembali</td>
                                    <td>{{ \Carbon\Carbon::parse($borrowing->return_date)->format('d F Y') }}</td>
                                </tr>
                                @if($borrowing->returned_at)
                                <tr>
                                    <td class="text-muted">Dikembalikan Pada</td>
                                    <td><span class="text-success"><strong>{{ \Carbon\Carbon::parse($borrowing->returned_at)->format('d F Y H:i') }}</strong></span></td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-primary"><i class="fas fa-info-circle mr-2"></i>Tujuan Peminjaman</h5>
                            <p class="text-muted">{{ $borrowing->purpose }}</p>

                            @if($borrowing->notes)
                                <h5 class="text-primary"><i class="fas fa-sticky-note mr-2"></i>Catatan</h5>
                                <p class="text-muted">{{ $borrowing->notes }}</p>
                            @endif
                        </div>
                    </div>

                    @if($borrowing->approvedBy)
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary"><i class="fas fa-user-check mr-2"></i>Diproses Oleh</h5>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td class="text-muted" width="40%">Nama</td>
                                        <td><strong>{{ $borrowing->approvedBy->name }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Tanggal</td>
                                        <td>{{ $borrowing->approved_at ? \Carbon\Carbon::parse($borrowing->approved_at)->format('d F Y H:i') : '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-cogs"></i> Aksi</h3>
                </div>
                <div class="card-body">
                    @if($borrowing->status == 'pending')
                        <form action="{{ route('borrowings.approve', $borrowing) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block" onclick="return confirm('Yakin ingin menyetujui peminjaman ini?')">
                                <i class="fas fa-check"></i> Setujui Peminjaman
                            </button>
                        </form>
                        <button type="button" class="btn btn-danger btn-block mb-2" data-toggle="modal" data-target="#rejectModal">
                            <i class="fas fa-times"></i> Tolak Peminjaman
                        </button>
                    @endif

                    @if($borrowing->status == 'approved' && !$borrowing->returned_at)
                        <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-block" onclick="return confirm('Konfirmasi pengembalian aset?')">
                                <i class="fas fa-undo"></i> Konfirmasi Pengembalian
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('borrowings.index') }}" class="btn btn-secondary btn-block">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>

                    <form action="{{ route('borrowings.destroy', $borrowing) }}" method="POST" class="mt-2" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-block btn-sm">
                            <i class="fas fa-trash"></i> Hapus Data
                        </button>
                    </form>
                </div>
            </div>

            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-history"></i> Timeline</h3>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-inverse">
                        <div class="time-label">
                            <span class="bg-primary">{{ \Carbon\Carbon::parse($borrowing->created_at)->format('d M Y') }}</span>
                        </div>
                        <div>
                            <i class="fas fa-paper-plane bg-info"></i>
                            <div class="timeline-item">
                                <h3 class="timeline-header">Permohonan Diajukan</h3>
                            </div>
                        </div>

                        @if($borrowing->approved_at)
                        <div>
                            @if($borrowing->status == 'approved')
                                <i class="fas fa-check bg-success"></i>
                            @else
                                <i class="fas fa-times bg-danger"></i>
                            @endif
                            <div class="timeline-item">
                                <span class="time"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($borrowing->approved_at)->format('d M Y') }}</span>
                                <h3 class="timeline-header">
                                    {{ $borrowing->status == 'approved' ? 'Disetujui' : 'Ditolak' }}
                                </h3>
                            </div>
                        </div>
                        @endif

                        @if($borrowing->returned_at)
                        <div>
                            <i class="fas fa-undo bg-success"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($borrowing->returned_at)->format('d M Y') }}</span>
                                <h3 class="timeline-header">Aset Dikembalikan</h3>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    @if($borrowing->status == 'pending')
    <div class="modal fade" id="rejectModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tolak Peminjaman</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('borrowings.reject', $borrowing) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea name="rejection_reason" class="form-control" rows="3" required placeholder="Tuliskan alasan penolakan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@stop
