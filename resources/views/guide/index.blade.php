@extends('adminlte::page')

@section('title', 'Panduan Pengguna (User Guide)')

@section('content_header')
    <h1><i class="fas fa-book-reader mr-2 text-primary"></i> Panduan Pengguna BMN System</h1>
@stop

@section('content')
<div class="row">
    <!-- Sidebar Navigasi -->
    <div class="col-md-3">
        <div class="card card-primary card-outline shadow-sm sticky-top" style="top: 20px;">
            <div class="card-body p-0">
                <ul class="nav nav-pills flex-column guide-nav">
                    <li class="nav-item">
                        <a href="#intro" class="nav-link active" data-toggle="pill">
                            <i class="fas fa-info-circle mr-2"></i> 1. Memulai & Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#master-data" class="nav-link" data-toggle="pill">
                            <i class="fas fa-database mr-2"></i> 2. Pengaturan Master Data
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#asset-tetap" class="nav-link" data-toggle="pill">
                            <i class="fas fa-box mr-2"></i> 3. Manajemen Aset Tetap
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#import-detail" class="nav-link" data-toggle="pill">
                            <i class="fas fa-file-import mr-2"></i> 4. Panduan Import Massal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#asset-lancar" class="nav-link" data-toggle="pill">
                            <i class="fas fa-boxes mr-2"></i> 5. Aset Lancar (Persediaan)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#rkbmn" class="nav-link" data-toggle="pill">
                            <i class="fas fa-calendar-check mr-2"></i> 6. Perencanaan (RKBMN)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#qr-code" class="nav-link" data-toggle="pill">
                            <i class="fas fa-qrcode mr-2"></i> 7. Penggunaan QR Code
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#update" class="nav-link" data-toggle="pill">
                            <i class="fas fa-sync-alt mr-2"></i> 8. Pembaruan Sistem
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Konten Panduan -->
    <div class="col-md-9">
        <div class="tab-content shadow-sm">
            
            <!-- 1. Memulai & Dashboard -->
            <div class="tab-pane fade show active" id="intro">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-primary">1. Memulai & Dashboard</h3>
                    </div>
                    <div class="card-body">
                        <p>Selamat datang di sistem manajemen BMN. Setelah Anda login, Anda akan disuguhkan halaman Dashboard yang memberikan ringkasan kondisi aset secara real-time.</p>
                        
                        <div class="text-center mb-4">
                            <img src="{{ asset('img/guide/dashboard.png') }}" class="img-fluid rounded shadow-sm border" alt="Dashboard View">
                            <p class="small text-muted mt-2">Gambar 1.1: Tampilan Dashboard Utama</p>
                        </div>

                        <h6><strong>Langkah Memahami Dashboard:</strong></h6>
                        <ol>
                            <li><strong>Widget Statistik:</strong> Di bagian atas, Anda dapat melihat total Aset Tetap, Aset Lancar, dan total nilai perolehan.</li>
                            <li><strong>Grafik Kondisi:</strong> Lingkaran grafik menunjukkan perbandingan aset dalam kondisi Baik, Rusak Ringan, dan Rusak Berat.</li>
                            <li><strong>Aktivitas Terbaru:</strong> Di bagian kanan, terdapat log aktivitas siapa saja yang melakukan perubahan data terakhir.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- 2. Master Data -->
            <div class="tab-pane fade" id="master-data">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-primary">2. Pengaturan Master Data</h3>
                    </div>
                    <div class="card-body">
                        <p>Sebelum menginput aset, Anda harus memastikan data master sudah terisi dengan benar.</p>
                        
                        <div class="alert alert-warning py-2 mb-4">
                            <small><i class="fas fa-exclamation-triangle mr-1"></i> Penting: Master Data adalah fondasi sistem. Kesalahan input di sini akan mempengaruhi laporan akhir.</small>
                        </div>

                        <h6><strong>Langkah-Langkah:</strong></h6>
                        <ul>
                            <li class="mb-3">
                                <strong>Satuan Kerja (Units):</strong>
                                <p class="small text-muted">Menu: <code>Master Data > Satuan Kerja</code>. Tambahkan unit kerja (Fakultas/Biro/Lembaga) yang ada di instansi Anda.</p>
                            </li>
                            <li class="mb-3">
                                <strong>Kategori Aset:</strong>
                                <p class="small text-muted">Menu: <code>Master Data > Jenis Aset Tetap</code>. Pastikan kategori sesuai dengan standar SIMAN/Sakti (Tanah, Peralatan, Gedung, dll).</p>
                            </li>
                            <li class="mb-3">
                                <strong>Lokasi Ruang:</strong>
                                <p class="small text-muted">Menu: <code>Master Data > Lokasi Ruang</code>. Daftarkan nama ruangan (Gedung A Lantai 1, Lab Komputer, dll).</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 3. Manajemen Aset Tetap -->
            <div class="tab-pane fade" id="asset-tetap">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-primary">3. Manajemen Aset Tetap</h3>
                    </div>
                    <div class="card-body">
                        <p>Modul ini adalah jantung dari aplikasi untuk mencatat semua Barang Milik Negara.</p>
                        
                        <div class="text-center mb-4">
                            <img src="{{ asset('img/guide/header.png') }}" class="img-fluid rounded shadow-sm border" alt="Asset Header">
                            <p class="small text-muted mt-2">Gambar 3.1: Menu Akses Aset Tetap</p>
                        </div>

                        <h6><strong>Cara Menambah Aset Secara Manual:</strong></h6>
                        <ol>
                            <li>Buka menu <strong>Inventarisasi > Aset Tetap</strong>.</li>
                            <li>Klik tombol biru <strong>"Tambah Aset"</strong> di pojok kanan atas.</li>
                            <li>Isi form yang muncul:
                                <ul>
                                    <li><strong>Kode Barang:</strong> 10 digit kode akun barang.</li>
                                    <li><strong>NUP:</strong> Nomor Urut Pendaftaran.</li>
                                    <li><strong>Kondisi:</strong> Pilih status fisik saat ini.</li>
                                </ul>
                            </li>
                            <li>Klik <strong>Simpan</strong>. Sistem akan otomatis membuat entri baru dan menghasilkan QR Code unik.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- 4. Panduan Import Massal -->
            <div class="tab-pane fade" id="import-detail">
                <div class="card border-0">
                    <div class="card-header bg-white text-dark">
                        <h3 class="card-title font-weight-bold text-primary">4. Panduan Import Massal (Skala Besar)</h3>
                    </div>
                    <div class="card-body">
                        <p>Fitur ini memungkinkan Anda memasukkan ribuan data dalam hitungan menit.</p>

                        <div class="text-center mb-4">
                            <img src="{{ asset('img/guide/import_ui.png') }}" class="img-fluid rounded shadow-sm border" alt="Import UI">
                            <p class="small text-muted mt-2">Gambar 4.1: Antarmuka Proses Import Data</p>
                        </div>

                        <h6><strong>Langkah Detail Import (> 100.000 data):</strong></h6>
                        <ol>
                            <li>Gunakan tombol <strong>"Import Excel/CSV"</strong>.</li>
                            <li><strong>Penting:</strong> Untuk data sangat besar, gunakan format <strong>CSV</strong>.</li>
                            <li>Klik <strong>"Choose File"</strong> dan pilih file Anda.</li>
                            <li>Klik <strong>"Upload & Import"</strong>.</li>
                            <li>Sistem akan masuk ke tahap <strong>"Counting"</strong> (menghitung data), lalu <strong>"Processing"</strong>.</li>
                            <li>Perhatikan Progress Bar. Anda bisa memantau pertambahan baris data yang berhasil masuk secara real-time.</li>
                        </ol>
                        
                        <div class="p-3 bg-light border-left border-info rounded">
                            <small><strong>Note:</strong> Jika terjadi error "Gagal Menghubungi Server", kemungkinan file terlalu besar. Pecahlah file menjadi maksimal 50.000 baris per unggahan.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Aset Lancar -->
            <div class="tab-pane fade" id="asset-lancar">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-primary">5. Aset Lancar (Persediaan)</h3>
                    </div>
                    <div class="card-body">
                        <p>Mengelola stok barang habis pakai seperti alat tulis, bahan pembersih, dll.</p>
                        
                        <h6><strong>Siklus Stok:</strong></h6>
                        <div class="row">
                            <div class="col-md-6 border-right">
                                <h6 class="font-weight-bold text-success">Barang Masuk</h6>
                                <p class="small">Lakukan input di menu <strong>Transaksi Persediaan</strong> dengan tipe <strong>"Masuk"</strong>. Stok di gudang akan bertambah otomatis.</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="font-weight-bold text-danger">Barang Keluar</h6>
                                <p class="small">Pilih tipe <strong>"Keluar"</strong> saat ada permintaan pemakaian barang. Stok akan berkurang dan tercatat siapa penggunanya.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. QR Code -->
            <div class="tab-pane fade" id="qr-code">
                <div class="card border-0">
                    <div class="card-header bg-white text-dark">
                        <h3 class="card-title font-weight-bold text-primary">6. Penggunaan QR Code</h3>
                    </div>
                    <div class="card-body">
                        <p>Sistem ini terintegrasi dengan QR Code untuk audit fisik yang cepat.</p>

                        <div class="text-center mb-4">
                            <img src="{{ asset('img/guide/qr_scanner.png') }}" class="img-fluid rounded shadow-sm border" alt="QR Scanner">
                            <p class="small text-muted mt-2">Gambar 6.1: Proses Pemindaian QR Code Aset</p>
                        </div>

                        <h6><strong>Langkah Audit Lapangan:</strong></h6>
                        <ol>
                            <li>Buka menu <strong>Scan QR / Cek Aset</strong> di HP atau Laptop.</li>
                            <li>Izinkan akses kamera.</li>
                            <li>Arahkan kamera ke label aset.</li>
                            <li>Sistem akan langsung menampilkan informasi: Nama Aset, NUP, Lokasi, dan Kondisi Terakhir tanpa perlu mencari manual.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- RKBMN -->
            <div class="tab-pane fade" id="rkbmn">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-primary">5. Perencanaan (RKBMN)</h3>
                    </div>
                    <div class="card-body">
                        <p>Modul RKBMN digunakan untuk merencanakan kebutuhan aset di masa mendatang secara sistematis.</p>
                        
                        <div class="text-center mb-4">
                            <img src="{{ asset('img/guide/rkbmn_ui.png') }}" class="img-fluid rounded shadow-sm border" alt="RKBMN UI">
                            <p class="small text-muted mt-2">Gambar 5.1: Dashboard Perencanaan (RKBMN)</p>
                        </div>

                        <div class="accordion" id="guideRKBMN">
                            <div class="card mb-2 shadow-none border">
                                <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#stepProcurement">
                                    <h6 class="mb-0">1. Usulan Pengadaan</h6>
                                </div>
                                <div id="stepProcurement" class="collapse show" data-parent="#guideRKBMN">
                                    <div class="card-body">
                                        <p>Gunakan ini untuk mengajukan pembelian aset baru.</p>
                                        <ol>
                                            <li>Menu: <strong>PERENCANAAN (RKBMN) > Usulan Pengadaan</strong>.</li>
                                            <li>Klik <strong>"Tambah Usulan"</strong>.</li>
                                            <li>Pilih <strong>Kategori Barang</strong> (misal: Laptop, Meja, dll).</li>
                                            <li>Masukkan <strong>Jumlah</strong> dan <strong>Estimasi Biaya</strong>.</li>
                                            <li>Berikan alasan kebutuhan yang kuat untuk verifikasi pimpinan.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-2 shadow-none border">
                                <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#stepMaintenance">
                                    <h6 class="mb-0">2. Usulan Pemeliharaan</h6>
                                </div>
                                <div id="stepMaintenance" class="collapse" data-parent="#guideRKBMN">
                                    <div class="card-body">
                                        <p>Untuk mengajukan biaya perbaikan aset yang sudah ada.</p>
                                        <ol>
                                            <li>Menu: <strong>Usulan Pemeliharaan</strong>.</li>
                                            <li>Klik <strong>"Pilih Aset"</strong> dari daftar yang sudah ada di sistem.</li>
                                            <li>Masukkan jenis pemeliharaan (Rutin/Berat) dan estimasi biayanya.</li>
                                            <li>Klik Simpan untuk mengirim usulan ke pusat.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-2 shadow-none border">
                                <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#stepAction">
                                    <h6 class="mb-0">3. Usulan Pemanfaatan & Penghapusan</h6>
                                </div>
                                <div id="stepAction" class="collapse" data-parent="#guideRKBMN">
                                    <div class="card-body">
                                        <p>Gunakan modul ini untuk merencanakan aset yang akan disewakan (Pemanfaatan) atau aset yang sudah rusak total dan ingin dikeluarkan dari daftar (Penghapusan).</p>
                                        <ul>
                                            <li><strong>Pemanfaatan:</strong> Memaksimalkan potensi aset untuk PNBP.</li>
                                            <li><strong>Penghapusan:</strong> Membersihkan daftar aset dari barang yang sudah tidak memiliki nilai ekonomis/fisik.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 8. Update Sistem -->
            <div class="tab-pane fade" id="update">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-primary">8. Pembaruan Sistem (System Update)</h3>
                    </div>
                    <div class="card-body">
                        <p>Menjaga aplikasi tetap mutakhir dengan satu klik.</p>
                        <ol>
                            <li>Masuk ke menu <strong>PENGATURAN > Update Sistem</strong>.</li>
                            <li>Klik <strong>"Cek Pembaruan"</strong>.</li>
                            <li>Jika muncul teks <span class="badge badge-info">Terdapat X pembaruan tersedia</span>, barulah klik tombol hijau <strong>"Perbarui Sistem"</strong>.</li>
                            <li>Sistem akan melakukan penarikan kode (git pull) secara aman.</li>
                        </ol>
                        <div class="alert alert-danger py-2 mt-3">
                            <small><i class="fas fa-exclamation-circle mr-1"></i> Jangan mematikan koneksi internet saat proses update sedang berjalan.</small>
                        </div>
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
        padding: 15px 20px;
        color: #495057;
        font-weight: 500;
        border-bottom: 1px solid rgba(0,0,0,.05);
        transition: all 0.3s;
    }
    .guide-nav .nav-link:hover {
        background-color: #f1f3f5;
    }
    .guide-nav .nav-link.active {
        background-color: #fff;
        color: #007bff;
        border-left: 5px solid #007bff;
        font-weight: 700;
        box-shadow: 2px 0 5px rgba(0,0,0,0.05);
    }
    .tab-content {
        background: #fff;
        border-radius: 8px;
        min-height: 600px;
        padding: 10px;
    }
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,.05) !important;
        margin-bottom: 15px;
    }
    img {
        max-width: 100%;
        height: auto;
        margin-top: 10px;
    }
    code {
        background: #f8f9fa;
        padding: 2px 5px;
        border-radius: 4px;
        color: #e83e8c;
    }
    .sticky-top {
        z-index: 1020;
    }
</style>
@stop
