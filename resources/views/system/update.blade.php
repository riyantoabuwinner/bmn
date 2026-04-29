@extends('adminlte::page')

@section('title', 'Update Sistem')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Update Sistem</h1>
        <div>
            <button id="btnCheck" class="btn btn-dark btn-sm font-weight-bold mr-2">
                <i class="fas fa-search mr-1"></i> Cek Pembaruan
            </button>
            <button id="btnUpdate" class="btn btn-success btn-sm font-weight-bold" style="display: none;">
                <i class="fas fa-sync-alt mr-1"></i> Perbarui Sistem
            </button>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Status Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <h3 class="card-title text-muted">
                        <i class="fas fa-laptop mr-2 text-primary"></i> Status Branch & Lingkungan Server
                    </h3>
                </div>
                <div class="card-body py-3">
                    <div id="statusInfo">
                        <span class="mr-4 text-sm">Branch: <strong>{{ $status['branch'] }}</strong></span>
                        <span class="mr-4 text-sm">Hash: <strong>{{ $status['hash'] }}</strong></span>
                        <span class="text-sm">Tanggal: <strong>{{ $status['date'] }}</strong></span>
                    </div>
                    <div id="noUpdateAlert" class="mt-2" style="display: none;">
                        <div class="alert alert-success py-2 mb-0">
                            <i class="fas fa-check-circle mr-2"></i> 
                            Sistem sudah menggunakan versi terbaru (Up-to-date).
                        </div>
                    </div>
                    <div id="updateAlert" class="mt-2" style="display: none;">
                        <div class="alert alert-info py-2 mb-0">
                            <i class="fas fa-info-circle mr-2"></i> 
                            Terdapat <strong id="behindCount">0</strong> pembaruan baru tersedia di repository. Silakan klik tombol <strong>Perbarui Sistem</strong>.
                        </div>
                    </div>
                    <div id="migrationAlert" class="mt-2" style="display: none;">
                        <div class="alert alert-warning py-2 mb-0">
                            <i class="fas fa-exclamation-triangle mr-2"></i> 
                            Pembaruan ini mencakup <strong>migrasi database</strong>. Mohon lakukan migrasi secara manual lewat terminal setelah update selesai.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Git Log Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <h3 class="card-title text-muted">
                        <i class="far fa-clock mr-2 text-info"></i> Riwayat Perubahan (Git Log)
                    </h3>
                </div>
                <div class="card-body p-0">
                    <pre class="bg-dark text-light p-4 mb-0" style="max-height: 300px; overflow-y: auto; font-family: 'Courier New', Courier, monospace; border-radius: 0 0 4px 4px;">@foreach($logs as $log)
{{ $log }}
@endforeach</pre>
                </div>
            </div>

            <!-- Execution Output Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h3 class="card-title text-muted">
                        <i class="fas fa-terminal mr-2 text-success"></i> Output Eksekusi Git Pull (Terakhir)
                    </h3>
                </div>
                <div class="card-body p-0">
                    <pre id="executionOutput" class="bg-dark text-light p-4 mb-0" style="min-height: 150px; font-family: 'Courier New', Courier, monospace; border-radius: 0 0 4px 4px;">Belum ada output eksekusi terbaru. Silakan tekan tombol "Cek Pembaruan" untuk memulai.</pre>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#btnCheck').click(function() {
            const btn = $(this);
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Mengecek...');
            
            $.post('{{ route("system.update.check") }}', {
                _token: '{{ csrf_token() }}'
            })
            .done(function(data) {
                if (data.success) {
                    $('#statusInfo').html(`
                        <span class="mr-4 text-sm">Branch: <strong>${data.status.branch}</strong></span>
                        <span class="mr-4 text-sm">Hash: <strong>${data.status.hash}</strong></span>
                        <span class="text-sm">Tanggal: <strong>${data.status.date}</strong></span>
                    `);
                    
                    if (data.status.behind > 0) {
                        $('#behindCount').text(data.status.behind);
                        $('#updateAlert').fadeIn();
                        $('#noUpdateAlert').hide();
                        $('#btnUpdate').fadeIn();
                    } else {
                        $('#updateAlert').hide();
                        $('#noUpdateAlert').fadeIn();
                        $('#btnUpdate').hide();
                        toastr.success('Sistem sudah menggunakan versi terbaru.');
                    }
                    
                    if (data.has_migrations) {
                        $('#migrationAlert').fadeIn();
                    } else {
                        $('#migrationAlert').hide();
                    }
                    
                    // Update logs
                    let logHtml = '';
                    data.logs.forEach(function(log) {
                        logHtml += log + '\n';
                    });
                    $('.bg-dark:eq(0)').text(logHtml);
                    
                    $('#executionOutput').text('Pengecekan selesai. ' + (data.status.behind > 0 ? 'Pembaruan tersedia.' : 'Sistem up-to-date.'));
                }
            })
            .fail(function() {
                toastr.error('Gagal menghubungi server.');
            })
            .always(function() {
                btn.prop('disabled', false).html('<i class="fas fa-search mr-1"></i> Cek Pembaruan');
            });
        });

        $('#btnUpdate').click(function() {
            if (!confirm('Apakah Anda yakin ingin memperbarui sistem? Ini akan menjalankan perintah git pull.')) return;
            
            const btn = $(this);
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Memperbarui...');
            
            $.post('{{ route("system.update.apply") }}', {
                _token: '{{ csrf_token() }}'
            })
            .done(function(data) {
                $('#executionOutput').text(data.output);
                if (data.success) {
                    toastr.success(data.message);
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(data.message);
                }
            })
            .fail(function() {
                toastr.error('Gagal memperbarui sistem.');
            })
            .always(function() {
                btn.prop('disabled', false).html('<i class="fas fa-sync-alt mr-1"></i> Perbarui Sistem');
            });
        });
    });
</script>
@stop

@section('css')
<style>
    .card {
        border-radius: 8px;
    }
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,.05);
        padding: 1rem 1.25rem;
    }
    pre {
        color: #e9ecef;
        font-size: 0.9rem;
    }
    .alert {
        border: none;
        border-radius: 6px;
    }
</style>
@stop
