@extends('adminlte::page')

@section('title', 'Manajemen Aset')

@section('content_header')
    <h1>Aset Tetap</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="icon fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="icon fas fa-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="icon fas fa-info"></i> {{ session('info') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Aset</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-file-import"></i> Import
                </button>
                <a href="{{ route('assets.export') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-file-export"></i> Export
                </a>
                <a href="{{ route('assets.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Aset
                </a>
                <button type="button" id="btn-bulk-delete" class="btn btn-danger btn-sm" style="display:none;">
                    <i class="fas fa-trash"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                </button>
            </div>
        </div>
        
        <!-- Filter Section -->
        <div class="card-body border-bottom">
            <form method="GET" action="{{ route('assets.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Pencarian</label>
                            <input type="text" name="search" class="form-control" placeholder="Nama, Kode, NUP..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                         <div class="form-group">
                            <label>Jenis Aset</label>
                            <select name="category_id" class="form-control">
                                <option value="">Semua Jenis</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Kondisi</label>
                            <select name="kondisi" class="form-control">
                                <option value="">Semua Kondisi</option>
                                <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Lokasi..." value="{{ request('lokasi') }}">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="number" name="tahun_perolehan" class="form-control" placeholder="YYYY" value="{{ request('tahun_perolehan') }}">
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <div class="form-group w-100">
                             <button type="submit" class="btn btn-primary btn-block mb-1" title="Cari"><i class="fas fa-search"></i></button>
                             <a href="{{ route('assets.index') }}" class="btn btn-secondary btn-block" title="Reset"><i class="fas fa-undo"></i></a>
                        </div>
                    </div>
                </div>
            </form>
            
            <!-- Results Info & Per Page Selector -->
            <div class="row mt-3">
                <div class="col-md-6">
                    @if(request()->hasAny(['search', 'kondisi', 'lokasi', 'tahun_perolehan']))
                        <div class="alert alert-info mb-0 py-2">
                            <i class="fas fa-info-circle"></i> 
                            Ditemukan <strong>{{ number_format($totalFiltered) }}</strong> data dari total <strong class="total-assets-count">{{ number_format($assets->total()) }}</strong> aset
                        </div>
                    @else
                        <div class="text-muted">
                            Total: <strong class="total-assets-count">{{ number_format($assets->total()) }}</strong> aset
                        </div>
                    @endif
                </div>
                <div class="col-md-6 text-right">
                    <form method="GET" action="{{ route('assets.index') }}" class="form-inline justify-content-end">
                        @foreach(request()->except('per_page') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        
                        <label class="mr-2">Tampilkan:</label>
                        <select name="per_page" class="form-control form-control-sm" onchange="this.form.submit()" style="width: auto;">
                            <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            <option value="500" {{ request('per_page') == 500 ? 'selected' : '' }}>500</option>
                            <option value="1000" {{ request('per_page') == 1000 ? 'selected' : '' }}>1000</option>
                        </select>
                        <span class="ml-2">baris</span>
                    </form>
                </div>
            </div>
            </div>
        </div>

        <!-- Import Progress Bar (Main View) -->
        <div id="importProgressContainer" style="display:none;" class="card-body border-bottom bg-light">
            <div class="row align-items-center">
                <div class="col-md-1">
                    <i class="fas fa-file-import fa-2x text-primary"></i>
                </div>
                <div class="col-md-11">
                    <div class="d-flex justify-content-between mb-1">
                        <span id="mainImportStatusText" class="font-weight-bold text-primary">Sedang mengimport data...</span>
                        <span id="mainImportDetailsText" class="text-muted small">0 dari 0 baris</span>
                    </div>
                    <div class="progress mb-2" style="height: 20px;">
                        <div id="mainImportProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                    <div class="text-right">
                        <button type="button" id="btnResetImport" class="btn btn-xs btn-outline-danger">
                            <i class="fas fa-sync"></i> Reset Tampilan Import (Gunakan jika macet)
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th width="30px"><input type="checkbox" id="select-all"></th>
                        <th>ID Aset Unik</th>
                        <th>Kode Barang</th>
                        <th>NUP</th>
                        <th>Nama Barang</th>
                        <th>Tgl Perolehan</th>
                        <th>Kondisi</th>
                        <th>Status Inventarisasi</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $asset)
                        <tr>
                            <td><input type="checkbox" class="asset-checkbox" value="{{ $asset->id }}"></td>
                            <td><code>{{ $asset->unique_asset_id ?? '-' }}</code></td>
                            <td>{{ $asset->kode_barang }}</td>
                            <td>{{ $asset->nup }}</td>
                            <td>{{ $asset->nama_barang }}</td>
                            <td>{{ $asset->tgl_perolehan_pertama ? $asset->tgl_perolehan_pertama->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($asset->kondisi == 'Baik')
                                    <span class="badge badge-success">Baik</span>
                                @elseif($asset->kondisi == 'Rusak Ringan')
                                    <span class="badge badge-warning">Rusak Ringan</span>
                                @else
                                    <span class="badge badge-danger">Rusak Berat</span>
                                @endif
                            </td>
                            <td>
                                @if($asset->last_inventory_at)
                                    <span class="text-success small" title="{{ $asset->last_inventory_at->format('d/m/Y H:i') }}">
                                        <i class="fas fa-check-circle"></i> Terdata
                                    </span>
                                @else
                                    <span class="text-danger small"><i class="fas fa-times-circle"></i> Belum Sensus</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('assets.update-inventory', $asset) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-xs btn-outline-success" title="Mutakhirkan Inventarisasi (Sensus)">
                                        <i class="fas fa-clipboard-check"></i>
                                    </button>
                                </form>
                                <a href="{{ route('assets.show', $asset) }}" class="btn btn-xs btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('assets.edit', $asset) }}" class="btn btn-xs btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('assets.destroy', $asset) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus aset ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data aset ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="card-footer clearfix">
            {{ $assets->links() }}
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data Aset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="importForm" action="{{ route('assets.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file">Pilih File Excel (.xlsx, .xls)</label>
                            <input type="file" name="file" class="form-control-file" required>
                            <small class="text-muted">Pastikan format sesuai template. <a href="{{ route('assets.template') }}">Download Template</a></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="importCloseBtn">Tutup</button>
                        <button type="submit" id="importBtn" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
<script>
    // Bulk Delete Logic
    const selectAll = document.getElementById('select-all');
    const assetCheckboxes = document.querySelectorAll('.asset-checkbox');
    const btnBulkDelete = document.getElementById('btn-bulk-delete');
    const selectedCount = document.getElementById('selected-count');

    function updateBulkDeleteButton() {
        const checkedCount = document.querySelectorAll('.asset-checkbox:checked').length;
        if (checkedCount > 0) {
            btnBulkDelete.style.display = 'inline-block';
            selectedCount.innerText = checkedCount;
        } else {
            btnBulkDelete.style.display = 'none';
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            assetCheckboxes.forEach(cb => {
                cb.checked = selectAll.checked;
            });
            updateBulkDeleteButton();
        });
    }

    assetCheckboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            updateBulkDeleteButton();
            if (!this.checked) {
                selectAll.checked = false;
            } else {
                const allChecked = document.querySelectorAll('.asset-checkbox:checked').length === assetCheckboxes.length;
                selectAll.checked = allChecked;
            }
        });
    });

    btnBulkDelete.addEventListener('click', function() {
        const checkedIds = Array.from(document.querySelectorAll('.asset-checkbox:checked')).map(cb => cb.value);
        
        if (checkedIds.length === 0) return;

        if (confirm(`Apakah Anda yakin ingin menghapus ${checkedIds.length} aset yang dipilih?`)) {
            const originalText = this.innerHTML;
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';

            fetch('{{ route("assets.bulk-delete") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ ids: checkedIds })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Terjadi kesalahan saat menghapus data.');
                    this.disabled = false;
                    this.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menghubungi server.');
                this.disabled = false;
                this.innerHTML = originalText;
            });
        }
    });

    // Progress Bar Logic
    let pollInterval;
    
    function getProgressElements() {
        return {
            container: document.getElementById('importProgressContainer'),
            bar: document.getElementById('mainImportProgressBar'),
            status: document.getElementById('mainImportStatusText'),
            details: document.getElementById('mainImportDetailsText'),
            submitBtn: document.getElementById('importBtn'),
            closeBtn: document.getElementById('importCloseBtn')
        };
    }

    function pollProgress() {
        const elements = getProgressElements();
        
        const fetchProgress = () => {
            fetch('{{ route("assets.import.progress") }}')
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        if (pollInterval) clearInterval(pollInterval);
                        return;
                    }
                    
                    if (elements.bar) {
                        const displayPercentage = data.percentage || 0;
                        elements.bar.style.width = displayPercentage + '%';
                        elements.bar.setAttribute('aria-valuenow', displayPercentage);
                        elements.bar.innerHTML = displayPercentage + '%';

                        if (data.status === 'pending') {
                            if (elements.status) elements.status.innerText = 'Menunggu antrian...';
                            if (elements.details) elements.details.innerText = 'Mempersiapkan data...';
                        } else if (data.status === 'counting') {
                            if (elements.status) elements.status.innerText = 'Menganalisis file...';
                            if (elements.details) elements.details.innerText = 'Menghitung total baris data...';
                            elements.bar.style.width = '5%';
                        } else if (data.status === 'processing') {
                            if (elements.status) elements.status.innerText = 'Mengimport data... ' + displayPercentage + '%';
                            if (elements.details) {
                                let details = `${data.processed} dari ${data.total} baris tersimpan`;
                                if (data.processed > 0) {
                                    details += ' (Sedang berjalan)';
                                } else {
                                    details += ' (Memulai...)';
                                }
                                elements.details.innerText = details;
                            }
                        } else if (data.status === 'failed') {
                            if (elements.status) elements.status.innerText = '❌ Import Gagal';
                            if (elements.details) elements.details.innerText = data.error || 'Terjadi kesalahan internal.';
                            elements.bar.classList.add('bg-danger');
                        }
                        if (data.current_total !== undefined) {
                            const totalElements = document.querySelectorAll('.total-assets-count');
                            totalElements.forEach(el => {
                                el.innerText = new Intl.NumberFormat().format(data.current_total);
                            });
                        }
                    }
                    
                    if (data.finished) {
                        if (pollInterval) clearInterval(pollInterval);
                        
                        if (data.status === 'completed') {
                            if (elements.bar) {
                                elements.bar.style.width = '100%';
                                elements.bar.innerHTML = '100%';
                                elements.bar.classList.remove('progress-bar-animated', 'bg-primary');
                                elements.bar.classList.add('bg-success');
                            }
                            if (elements.status) elements.status.innerText = '✅ Import selesai!';
                            if (elements.details) elements.details.innerText = `${data.total} baris berhasil diimport`;
                        }
                        
                        // Clear session on server after a delay if successful, or keep if failed for visibility
                        if (data.status === 'completed') {
                            setTimeout(() => {
                                fetch('{{ route("assets.import.clear-session") }}');
                                if (elements.container) elements.container.style.display = 'none';
                                window.location.reload();
                            }, 3000);
                        }
                    }
                })
                .catch(err => {
                    console.error('Polling error:', err);
                });
        };

        // Initial fetch
        fetchProgress();
        
        // Then start interval
        if (pollInterval) clearInterval(pollInterval);
        pollInterval = setInterval(fetchProgress, 1000);
    }

    function resetImportForm() {
        const elements = getProgressElements();
        if (elements.submitBtn) {
            elements.submitBtn.disabled = false;
            elements.submitBtn.innerHTML = '<i class="fas fa-file-import"></i> Import';
        }
        if (elements.closeBtn) elements.closeBtn.disabled = false;
        if (elements.container) elements.container.style.display = 'none';
    }

    // Check for active import on page load
    window.addEventListener('load', function() {
        @if(session('asset_import_task_id'))
            const elements = getProgressElements();
            if (elements.container) {
                elements.container.style.display = 'block';
                if (elements.status) elements.status.innerText = 'Melanjutkan pemantauan import...';
                pollProgress();
            }
        @endif
    });

    const btnResetImport = document.getElementById('btnResetImport');
    if (btnResetImport) {
        btnResetImport.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin mereset tampilan import? Ini hanya membersihkan tampilan, proses di background mungkin masih berjalan.')) {
                if (pollInterval) clearInterval(pollInterval);
                fetch('{{ route("assets.import.clear-session") }}')
                    .then(() => window.location.reload());
            }
        });
    }

    const importForm = document.getElementById('importForm');
    if (importForm) {
        importForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const elements = getProgressElements();
            
            if (elements.submitBtn) {
                elements.submitBtn.disabled = true;
                elements.submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            }
            if (elements.closeBtn) elements.closeBtn.disabled = true;
            
            // Show progress in main view and hide modal
            if (elements.container) elements.container.style.display = 'block';
            $('#importModal').modal('hide');
            
            // Reset progress bar
            if (elements.bar) {
                elements.bar.style.width = '0%';
                elements.bar.innerHTML = '0%';
                elements.bar.classList.remove('bg-success');
                elements.bar.classList.add('bg-primary', 'progress-bar-animated');
            }
            if (elements.status) elements.status.innerText = 'Mengirim file ke server...';
            if (elements.details) elements.details.innerText = 'Mohon tunggu...';
            
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (elements.status) elements.status.innerText = 'Memulai proses import...';
                    pollProgress();
                } else {
                    alert(data.message || 'Terjadi kesalahan saat memulai import.');
                    resetImportForm();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menghubungi server.');
                resetImportForm();
            });
        });
    }
</script>
@stop
