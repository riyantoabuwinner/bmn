@extends('adminlte::page')

@section('title', 'Panduan Pengguna (User Guide)')

@section('content_header')
    <h1><i class="fas fa-book-reader mr-2 text-primary"></i> Panduan Pengguna BMN System</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-body p-0">
                <ul class="nav nav-pills flex-column guide-nav">
                    <li class="nav-item">
                        <a href="#intro" class="nav-link active" data-toggle="pill">
                            <i class="fas fa-info-circle mr-2"></i> Pendahuluan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#asset-tetap" class="nav-link" data-toggle="pill">
                            <i class="fas fa-box mr-2"></i> Manajemen Aset Tetap
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#asset-lancar" class="nav-link" data-toggle="pill">
                            <i class="fas fa-boxes mr-2"></i> Aset Lancar (Persediaan)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#transaksi" class="nav-link" data-toggle="pill">
                            <i class="fas fa-exchange-alt mr-2"></i> Transaksi & Pengelolaan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#rkbmn" class="nav-link" data-toggle="pill">
                            <i class="fas fa-calendar-check mr-2"></i> Perencanaan (RKBMN)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#wasdal" class="nav-link" data-toggle="pill">
                            <i class="fas fa-shield-alt mr-2"></i> Pengawasan (Wasdal)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#update" class="nav-link" data-toggle="pill">
                            <i class="fas fa-sync-alt mr-2"></i> Pembaruan Sistem
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="tab-content shadow-sm">
            <!-- Pendahuluan -->
            <div class="tab-pane fade show active" id="intro">
                <div class="card border-0">
                    <div class="card-header bg-white border-bottom-0">
                        <h3 class="card-title font-weight-bold text-primary">Selamat Datang di BMN System</h3>
                    </div>
                    <div class="card-body pt-0">
                        <p class="text-muted">Sistem Informasi Barang Milik Negara (BMN) ini dirancang untuk memudahkan pengelolaan siklus hidup aset negara secara transparan dan akuntabel.</p>
                        <hr>
                        <h5><i class="fas fa-star text-warning mr-2"></i> Fitur Utama</h5>
                        <ul class="list-unstyled ml-4">
                            <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> <strong>Bulk Import:</strong> Unggah ratusan ribu data aset sekaligus menggunakan Excel/CSV.</li>
                            <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> <strong>QR Code:</strong> Cek detail aset secara cepat melalui pemindaian kode QR.</li>
                            <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> <strong>Siklus Lengkap:</strong> Dari usulan pengadaan hingga penghapusan.</li>
                            <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> <strong>Keamanan Git:</strong> Pembaruan sistem aman dan terverifikasi via GitHub.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Manajemen Aset Tetap -->
            <div class="tab-pane fade" id="asset-tetap">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold">Manajemen Aset Tetap</h3>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="guideAsetTetap">
                            <div class="card mb-2 shadow-none border">
                                <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#stepImport">
                                    <h6 class="mb-0">1. Cara Import Aset Skala Besar</h6>
                                </div>
                                <div id="stepImport" class="collapse show" data-parent="#guideAsetTetap">
                                    <div class="card-body">
                                        <ol>
                                            <li>Masuk ke menu <strong>Inventarisasi > Aset Tetap</strong>.</li>
                                            <li>Klik tombol <strong>"Import Excel/CSV"</strong>.</li>
                                            <li>Pilih tab <strong>"Download Template"</strong> jika Anda belum memiliki format yang sesuai.</li>
                                            <li>Siapkan data Anda. Untuk data > 100.000 baris, <strong>sangat disarankan menggunakan format CSV</strong>.</li>
                                            <li>Unggah file Anda dan perhatikan <strong>Progress Bar</strong>. Jangan menutup halaman hingga proses selesai 100%.</li>
                                        </ol>
                                        <div class="alert alert-info py-2">
                                            <small><i class="fas fa-lightbulb mr-1"></i> Tips: Jika progress bar macet, klik tombol "Reset Tampilan Import" (Merah) dan coba lagi.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-2 shadow-none border">
                                <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#stepManual">
                                    <h6 class="mb-0">2. Menambah Aset Secara Manual</h6>
                                </div>
                                <div id="stepManual" class="collapse" data-parent="#guideAsetTetap">
                                    <div class="card-body">
                                        <ol>
                                            <li>Klik tombol <strong>"Tambah Aset"</strong> di halaman daftar aset.</li>
                                            <li>Isi data wajib: Kode Satker, Nama Barang, Kode Barang, dan NUP.</li>
                                            <li>Unggah foto aset jika tersedia untuk memudahkan identifikasi fisik.</li>
                                            <li>Klik simpan. QR Code akan otomatis dibuat oleh sistem.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aset Lancar -->
            <div class="tab-pane fade" id="asset-lancar">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold">Manajemen Aset Lancar (Persediaan)</h3>
                    </div>
                    <div class="card-body">
                        <p>Modul ini digunakan untuk barang habis pakai atau persediaan.</p>
                        <div class="accordion" id="guideAsetLancar">
                            <div class="card mb-2 shadow-none border">
                                <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#stepStock">
                                    <h6 class="mb-0">1. Mencatat Transaksi Masuk/Keluar</h6>
                                </div>
                                <div id="stepStock" class="collapse show" data-parent="#guideAsetLancar">
                                    <div class="card-body">
                                        <ol>
                                            <li>Menu <strong>Pengelolaan Aset Lancar > Transaksi Persediaan</strong>.</li>
                                            <li>Klik <strong>"Tambah Transaksi"</strong>.</li>
                                            <li>Pilih jenis transaksi: <strong>Masuk</strong> (untuk pengadaan/hibah) atau <strong>Keluar</strong> (untuk pemakaian).</li>
                                            <li>Pilih barang dan masukkan jumlahnya.</li>
                                            <li>Klik Simpan. Stok barang di tabel utama akan otomatis terupdate.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaksi -->
            <div class="tab-pane fade" id="transaksi">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold">Transaksi & Pengelolaan Aset</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="p-3 border rounded">
                                    <h6><i class="fas fa-truck text-primary mr-2"></i> Distribusi Aset</h6>
                                    <p class="small text-muted mb-0">Langkah mencatat penyerahan aset dari gudang ke unit kerja atau ruangan tertentu.</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 border rounded">
                                    <h6><i class="fas fa-hand-holding text-success mr-2"></i> Peminjaman Aset</h6>
                                    <p class="small text-muted mb-0">Prosedur pinjam pakai aset antar unit dengan batas waktu tertentu.</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 border rounded">
                                    <h6><i class="fas fa-wrench text-danger mr-2"></i> Maintenance</h6>
                                    <p class="small text-muted mb-0">Pencatatan biaya dan riwayat perbaikan fisik aset agar kondisi tetap prima.</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 border rounded">
                                    <h6><i class="fas fa-file-contract text-info mr-2"></i> PSP (Penetapan Status)</h6>
                                    <p class="small text-muted mb-0">Legalitas penggunaan aset di bawah naungan instansi yang berwenang.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RKBMN -->
            <div class="tab-pane fade" id="rkbmn">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-info">Perencanaan (RKBMN)</h3>
                    </div>
                    <div class="card-body">
                        <h5>Alur Pengajuan Rencana:</h5>
                        <div class="timeline timeline-inverse">
                            <div class="time-label">
                                <span class="bg-primary">Tahap 1</span>
                            </div>
                            <div>
                                <i class="fas fa-edit bg-blue"></i>
                                <div class="timeline-item shadow-none border">
                                    <h3 class="timeline-header">Input Usulan</h3>
                                    <div class="timeline-body">Admin Unit menginput daftar kebutuhan pengadaan atau pemeliharaan aset untuk tahun mendatang di menu RKBMN.</div>
                                </div>
                            </div>
                            <div class="time-label">
                                <span class="bg-warning">Tahap 2</span>
                            </div>
                            <div>
                                <i class="fas fa-tasks bg-yellow"></i>
                                <div class="timeline-item shadow-none border">
                                    <h3 class="timeline-header">Verifikasi</h3>
                                    <div class="timeline-body">Super Admin atau Pimpinan memeriksa kelayakan usulan berdasarkan data aset yang sudah ada (SBSK).</div>
                                </div>
                            </div>
                            <div>
                                <i class="far fa-clock bg-gray"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wasdal -->
            <div class="tab-pane fade" id="wasdal">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold">Pengawasan & Pengendalian (Wasdal)</h3>
                    </div>
                    <div class="card-body text-center py-5">
                        <i class="fas fa-shield-alt fa-3x text-info mb-3"></i>
                        <h5>Monitoring Aset Idle & Terbengkalai</h5>
                        <p class="text-muted mx-auto" style="max-width: 600px;">Gunakan menu Wasdal untuk mencatat aset yang tidak digunakan secara maksimal. Sistem akan memberikan alarm jika terdapat aset yang belum ditetapkan statusnya (PSP) lebih dari satu tahun.</p>
                    </div>
                </div>
            </div>

            <!-- Update Sistem -->
            <div class="tab-pane fade" id="update">
                <div class="card border-0">
                    <div class="card-header bg-white text-dark">
                        <h3 class="card-title font-weight-bold">Pembaruan Sistem (System Update)</h3>
                    </div>
                    <div class="card-body">
                        <div class="p-3 border-left border-success border-4 bg-light mb-4">
                            <strong><i class="fas fa-shield-alt text-success mr-2"></i> Keamanan Kode Utama</strong>
                            <p class="mb-0 small">Fitur ini menjamin aplikasi Anda selalu sinkron dengan versi terbaru dari tim pengembang pusat tanpa merusak data yang ada.</p>
                        </div>
                        <h6>Langkah Update Aman:</h6>
                        <ol>
                            <li>Buka menu <strong>PENGATURAN > Update Sistem</strong>.</li>
                            <li>Klik <strong>"Cek Pembaruan"</strong>.</li>
                            <li>Tunggu 10 detik hingga sistem memverifikasi versi di GitHub.</li>
                            <li>Jika muncul notifikasi update, baca <strong>Riwayat Perubahan</strong> untuk mengetahui fitur baru apa saja yang ditambahkan.</li>
                            <li>Klik <strong>"Perbarui Sistem"</strong> untuk melakukan sinkronisasi.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .guide-nav .nav-link {
        border-radius: 0;
        padding: 12px 20px;
        color: #495057;
        font-weight: 500;
        border-bottom: 1px solid rgba(0,0,0,.05);
    }
    .guide-nav .nav-link:last-child {
        border-bottom: none;
    }
    .guide-nav .nav-link.active {
        background-color: #f8f9fa;
        color: #007bff;
        border-left: 4px solid #007bff;
    }
    .tab-content {
        background: #fff;
        border-radius: 8px;
        min-height: 500px;
    }
    .card-header.pointer {
        cursor: pointer;
        transition: background 0.2s;
    }
    .card-header.pointer:hover {
        background: #f8f9fa !important;
    }
    .timeline::before {
        left: 31px;
        width: 2px;
    }
    .timeline > div > .timeline-item {
        margin-left: 60px;
    }
    .timeline > div > i {
        left: 18px;
        width: 30px;
        height: 30px;
        line-height: 30px;
    }
</style>
@stop
