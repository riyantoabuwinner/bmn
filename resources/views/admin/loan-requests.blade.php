@extends('adminlte::page')

@section('title', 'Ajuan Peminjaman')

@section('content_header')
    <h1>Ajuan Peminjaman Aset</h1>
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
            <h3 class="card-title">Daftar Ajuan Peminjaman</h3>
        </div>
        
        <!-- Status Filter -->
        <div class="card-body border-bottom pb-2">
            <div class="btn-group" role="group">
                <a href="{{ route('admin.loan-requests', ['status' => 'pending']) }}" 
                   class="btn btn-sm {{ $status == 'pending' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-clock"></i> Pending
                </a>
                <a href="{{ route('admin.loan-requests', ['status' => 'approved']) }}" 
                   class="btn btn-sm {{ $status == 'approved' ? 'btn-success' : 'btn-outline-success' }}">
                    <i class="fas fa-check"></i> Disetujui
                </a>
                <a href="{{ route('admin.loan-requests', ['status' => 'rejected']) }}" 
                   class="btn btn-sm {{ $status == 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}">
                    <i class="fas fa-times"></i> Ditolak
                </a>
                <a href="{{ route('admin.loan-requests', ['status' => 'all']) }}" 
                   class="btn btn-sm {{ $status == 'all' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                    <i class="fas fa-list"></i> Semua
                </a>
            </div>
        </div>

        <div class="card-body">
            @if($borrowings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal Ajuan</th>
                                <th>Peminjam</th>
                                <th>Aset</th>
                                <th>Kategori</th>
                                <th>Periode Peminjaman</th>
                                <th>Tujuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($borrowings as $borrowing)
                                <tr class="{{ $borrowing->status == 'pending' ? 'table-warning' : '' }}">
                                    <td>
                                        {{ $borrowing->created_at->format('d/m/Y H:i') }}
                                        @php
                                            $ageInDays = $borrowing->created_at->diffInDays(now());
                                        @endphp
                                        @if($borrowing->status == 'pending' && $ageInDays > 3)
                                            <span class="badge badge-warning">
                                                <i class="fas fa-exclamation-triangle"></i> {{ $ageInDays }} hari
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $borrowing->user->name ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">{{ $borrowing->user->email ?? '' }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $borrowing->asset->nama_barang }}</strong><br>
                                        <small class="text-muted">{{ $borrowing->asset->kode_barang }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $borrowing->asset->category->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>{{ \Carbon\Carbon::parse($borrowing->start_date)->format('d/m/Y') }}</strong>
                                        <br>s/d<br>
                                        <strong>{{ \Carbon\Carbon::parse($borrowing->end_date)->format('d/m/Y') }}</strong>
                                        @php
                                            $duration = \Carbon\Carbon::parse($borrowing->start_date)->diffInDays(\Carbon\Carbon::parse($borrowing->end_date));
                                        @endphp
                                        <br><small class="text-muted">({{ $duration + 1 }} hari)</small>
                                    </td>
                                    <td>
                                        <small>{{ \Illuminate\Support\Str::limit($borrowing->purpose, 50) }}</small>
                                    </td>
                                    <td>
                                        @if($borrowing->status == 'pending')
                                            <span class="badge badge-warning"><i class="fas fa-clock"></i> Pending</span>
                                        @elseif($borrowing->status == 'approved')
                                            <span class="badge badge-success"><i class="fas fa-check"></i> Disetujui</span>
                                            @if($borrowing->approver)
                                                <br><small class="text-muted">oleh {{ $borrowing->approver->name }}</small>
                                            @endif
                                        @elseif($borrowing->status == 'rejected')
                                            <span class="badge badge-danger"><i class="fas fa-times"></i> Ditolak</span>
                                            @if($borrowing->rejection_reason)
                                                <br><small class="text-danger">{{ $borrowing->rejection_reason }}</small>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('borrowings.show', $borrowing) }}" class="btn btn-info btn-sm mb-1" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($borrowing->status == 'pending')
                                            <form action="{{ route('borrowings.approve', $borrowing) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm mb-1" 
                                                        onclick="return confirm('Setujui peminjaman ini?')" title="Setujui">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            
                                            <button type="button" class="btn btn-danger btn-sm mb-1" 
                                                    data-toggle="modal" data-target="#rejectModal{{ $borrowing->id }}" title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>

                                            <!-- Reject Modal -->
                                            <div class="modal fade" id="rejectModal{{ $borrowing->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('borrowings.reject', $borrowing) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Tolak Peminjaman</h5>
                                                                <button type="button" class="close" data-dismiss="modal">
                                                                    <span>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Alasan Penolakan <span class="text-danger">*</span></label>
                                                                    <textarea name="rejection_reason" class="form-control" rows="3" 
                                                                              placeholder="Masukkan alasan penolakan..." required></textarea>
                                                                </div>
                                                                <div class="alert alert-warning">
                                                                    <i class="fas fa-info-circle"></i> 
                                                                    Peminjam: <strong>{{ $borrowing->user->name ?? 'N/A' }}</strong><br>
                                                                    Aset: <strong>{{ $borrowing->asset->nama_barang }}</strong>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="fas fa-times"></i> Tolak Peminjaman
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $borrowings->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    Tidak ada ajuan peminjaman 
                    @if($status != 'all')
                        dengan status <strong>{{ $status }}</strong>
                    @endif
                    saat ini.
                </div>
            @endif
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ \App\Models\Borrowing::where('status', 'pending')->count() }}</h3>
                    <p>Menunggu Persetujuan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ \App\Models\Borrowing::where('status', 'approved')->count() }}</h3>
                    <p>Disetujui</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ \App\Models\Borrowing::where('status', 'rejected')->count() }}</h3>
                    <p>Ditolak</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ \App\Models\Borrowing::count() }}</h3>
                    <p>Total Ajuan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-list"></i>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Auto-submit filter on change
        $('.status-filter').on('change', function() {
            window.location.href = "{{ route('admin.loan-requests') }}?status=" + $(this).val();
        });
    </script>
@stop
