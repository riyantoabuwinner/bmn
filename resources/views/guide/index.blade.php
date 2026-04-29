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
                        <a href="#management" class="nav-link" data-toggle="pill">
                            <i class="fas fa-tasks mr-2"></i> 6. Pengelolaan Aset Tetap
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#rkbmn" class="nav-link" data-toggle="pill">
                            <i class="fas fa-calendar-check mr-2"></i> 7. Perencanaan (RKBMN)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#wasdal" class="nav-link" data-toggle="pill">
                            <i class="fas fa-shield-alt mr-2"></i> 8. Pengawasan (WASDAL)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#qr-code" class="nav-link" data-toggle="pill">
                            <i class="fas fa-qrcode mr-2"></i> 9. Penggunaan QR Code
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#update" class="nav-link" data-toggle="pill">
                            <i class="fas fa-sync-alt mr-2"></i> 10. Pembaruan Sistem
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
                        <p>Halaman utama (Dashboard) adalah ringkasan seluruh kondisi BMN Anda. Pastikan Anda memahami setiap angka yang muncul.</p>
                        
                        <div class="text-center mb-4">
                            <img src="{{ asset('img/guide/dashboard.png') }}" class="img-fluid rounded shadow-sm border" alt="Dashboard View">
                            <p class="small text-muted mt-2">Gambar 1.1: Tampilan Dashboard Utama</p>
                        </div>

                        <h6><strong>Langkah Memahami Dashboard:</strong></h6>
                        <ol class="small">
                            <li><strong>Widget Statistik:</strong> Klik angka pada widget untuk langsung menuju daftar aset terkait.</li>
                            <li><strong>Grafik Kondisi:</strong> Arahkan kursor ke grafik untuk melihat jumlah detail aset berdasarkan kondisi fisik (Baik/Rusak).</li>
                            <li><strong>Log Aktivitas:</strong> Gunakan ini untuk memantau siapa yang baru saja mengubah data atau mengimport aset.</li>
                        </ol>
                    </div>
                    <div class="card-footer bg-light border-top">
                        <small class="text-info"><i class="fas fa-lightbulb mr-1"></i> <strong>Pro Tip:</strong> Dashboard diupdate secara real-time setiap kali ada transaksi baru.</small>
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
                        <p>Jangan menginput aset sebelum Master Data terisi. Ini adalah urutan yang wajib diikuti:</p>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="p-3 border rounded text-center mb-3">
                                    <i class="fas fa-building fa-2x text-primary mb-2"></i>
                                    <h6>1. Satuan Kerja</h6>
                                    <p class="xsmall text-muted">Daftarkan unit, fakultas, atau biro Anda.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 border rounded text-center mb-3">
                                    <i class="fas fa-tags fa-2x text-success mb-2"></i>
                                    <h6>2. Jenis Aset</h6>
                                    <p class="xsmall text-muted">Kategorikan barang sesuai standar akuntansi.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 border rounded text-center mb-3">
                                    <i class="fas fa-door-open fa-2x text-warning mb-2"></i>
                                    <h6>3. Lokasi Ruang</h6>
                                    <p class="xsmall text-muted">Tentukan titik fisik keberadaan barang.</p>
                                </div>
                            </div>
                        </div>

                        <h6><strong>Detail Cara Input:</strong></h6>
                        <ol class="small">
                            <li>Buka menu <strong>Master Data</strong> > Pilih kategori (misal: Lokasi Ruang).</li>
                            <li>Klik <strong>"Tambah Baru"</strong>.</li>
                            <li>Isi <strong>Nama Lokasi</strong> (misal: Ruang Lab Komputer 1) dan <strong>Kapasitas</strong> jika ada.</li>
                            <li>Klik Simpan. Sekarang lokasi ini bisa dipilih saat menambah aset.</li>
                        </ol>
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
                        <p>Mencatat aset secara manual satu-persatu.</p>
                        
                        <div class="text-center mb-4">
                            <img src="{{ asset('img/guide/header.png') }}" class="img-fluid rounded shadow-sm border" alt="Asset Header">
                            <p class="small text-muted mt-2">Gambar 3.1: Menu Akses Aset Tetap</p>
                        </div>

                        <h6><strong>Langkah Detil Tambah Manual:</strong></h6>
                        <ol class="small">
                            <li>Menu <strong>Inventarisasi > Aset Tetap</strong>.</li>
                            <li>Klik <strong>"Tambah Aset"</strong>.</li>
                            <li><strong>Form Detail Barang:</strong>
                                <ul>
                                    <li><strong>Kode Barang:</strong> Harus 10 digit (Contoh: 3020101002).</li>
                                    <li><strong>NUP:</strong> Nomor Urut. Pastikan tidak ganda untuk kode barang yang sama.</li>
                                    <li><strong>Tgl Perolehan:</strong> Tanggal saat barang dibeli/diterima.</li>
                                    <li><strong>Nilai Perolehan:</strong> Masukkan angka tanpa titik/koma (Contoh: 15000000).</li>
                                </ul>
                            </li>
                            <li><strong>Upload Foto:</strong> Klik area foto untuk mengambil gambar aset lewat kamera atau galeri.</li>
                            <li>Klik <strong>"Simpan Aset"</strong>.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- 4. Panduan Import Massal -->
            <div class="tab-pane fade" id="import-detail">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-primary">4. Panduan Import Massal (Skala Besar)</h3>
                    </div>
                    <div class="card-body">
                        <p>Solusi untuk migrasi data dari sistem lama atau dari SIMAN/Sakti.</p>

                        <div class="text-center mb-4">
                            <img src="{{ asset('img/guide/import_ui.png') }}" class="img-fluid rounded shadow-sm border" alt="Import UI">
                            <p class="small text-muted mt-2">Gambar 4.1: Antarmuka Proses Import Data</p>
                        </div>

                        <h6><strong>SOP Import Aman:</strong></h6>
                        <ol class="small">
                            <li>Klik <strong>"Import Excel/CSV"</strong>.</li>
                            <li><strong>Persiapan File:</strong> Gunakan <strong>CSV (Comma Separated Values)</strong> jika data lebih dari 50.000 baris untuk menghindari timeout server.</li>
                            <li><strong>Urutan Kolom:</strong> Pastikan urutan kolom sesuai dengan template (Kode Barang, NUP, Nama, dll).</li>
                            <li>Klik <strong>"Proses Import"</strong>.</li>
                            <li><strong>Tahap Pengecekan:</strong> Tunggu status "Counting". Sistem sedang menghitung jumlah baris data Anda.</li>
                            <li><strong>Tahap Eksekusi:</strong> Setelah muncul progress bar biru, biarkan halaman tetap terbuka. Anda akan melihat angka "Berhasil: X, Gagal: Y" bertambah secara real-time.</li>
                        </ol>
                    </div>
                    <div class="card-footer bg-light border-top">
                        <small class="text-danger"><i class="fas fa-exclamation-circle mr-1"></i> <strong>Troubleshooting:</strong> Jika progress bar berhenti lama, klik tombol <strong>"Reset Tampilan Import"</strong> lalu unggah ulang file Anda.</small>
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
                        <p>Mengelola pergerakan stok barang habis pakai.</p>

                        <div class="text-center mb-4">
                            <img src="{{ asset('img/guide/aset_lancar_detail.png') }}" class="img-fluid rounded shadow-sm border" alt="Current Asset Form">
                            <p class="small text-muted mt-2">Gambar 5.1: Form Transaksi Stok Persediaan</p>
                        </div>

                        <h6><strong>Langkah Kelola Stok:</strong></h6>
                        <ol class="small">
                            <li>Buka menu <strong>Transaksi Persediaan</strong>.</li>
                            <li>Klik <strong>"Tambah Transaksi"</strong>.</li>
                            <li><strong>Jenis Transaksi:</strong>
                                <ul>
                                    <li><strong>Masuk:</strong> Untuk stok baru (pembelian/hibah). Stok akan bertambah.</li>
                                    <li><strong>Keluar:</strong> Untuk pemakaian (diambil pegawai). Stok akan berkurang.</li>
                                </ul>
                            </li>
                            <li>Pilih <strong>Barang</strong> > Isi <strong>Jumlah</strong> > Isi <strong>Keterangan</strong> (misal: "Untuk kebutuhan ATK Fakultas").</li>
                            <li>Klik <strong>Simpan</strong>.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- 6. Pengelolaan Aset Tetap -->
            <div class="tab-pane fade" id="management">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-primary">6. Pengelolaan Aset Tetap (Operasional)</h3>
                    </div>
                    <div class="card-body">
                        <p>Setelah aset terdaftar, Anda harus mengelola status dan perawatannya.</p>
                        
                        <div class="text-center mb-4">
                            <img src="{{ asset('img/guide/management_ui.png') }}" class="img-fluid rounded shadow-sm border" alt="Management UI">
                            <p class="small text-muted mt-2">Gambar 6.1: Antarmuka Operasional Aset</p>
                        </div>

                        <div class="accordion" id="guideManagement">
                            <!-- PSP -->
                            <div class="card mb-2 shadow-none border">
                                <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#stepPSP">
                                    <h6 class="mb-0"><i class="fas fa-file-contract text-primary mr-2"></i> A. Penetapan Status (PSP)</h6>
                                </div>
                                <div id="stepPSP" class="collapse show" data-parent="#guideManagement">
                                    <div class="card-body">
                                        <p class="small">Proses melegalkan penggunaan aset secara administrasi negara.</p>
                                        <ol class="small">
                                            <li>Klik menu <strong>PSP</strong>. Lihat daftar barang yang belum berstatus PSP.</li>
                                            <li>Klik <strong>"Proses PSP"</strong>.</li>
                                            <li>Isi <strong>No SK</strong>, <strong>Tgl SK</strong>, dan <strong>Pejabat Penandatangan</strong>.</li>
                                            <li>Wajib unggah file SK asli (PDF).</li>
                                            <li>Simpan. Status di database akan berubah menjadi "PSP".</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <!-- Maintenance -->
                            <div class="card mb-2 shadow-none border">
                                <div class="card-header p-2 pointer" data-toggle="collapse" data-target="#stepMaint">
                                    <h6 class="mb-0"><i class="fas fa-wrench text-danger mr-2"></i> B. Maintenance & Riwayat Servis</h6>
                                </div>
                                <div id="stepMaint" class="collapse" data-parent="#guideManagement">
                                    <div class="card-body">
                                        <p class="small">Mencatat biaya perbaikan agar riwayat aset terlacak.</p>
                                        <ol class="small">
                                            <li>Pilih menu <strong>Maintenance Aset</strong>.</li>
                                            <li>Cari aset (misal: AC Lantai 2). Klik <strong>"Tambah Riwayat Servis"</strong>.</li>
                                            <li>Isi <strong>Tgl Servis</strong>, <strong>Biaya</strong>, dan <strong>Vendor/Tukang</strong> yang mengerjakan.</li>
                                            <li>Klik Simpan. Riwayat ini akan muncul saat Anda mencetak detail aset.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 7. RKBMN -->
            <div class="tab-pane fade" id="rkbmn">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-primary">7. Perencanaan (RKBMN)</h3>
                    </div>
                    <div class="card-body">
                        <p>Mengajukan usulan pengadaan atau pemeliharaan untuk anggaran tahun depan.</p>
                        
                        <div class="text-center mb-4">
                            <img src="{{ asset('img/guide/rkbmn_ui.png') }}" class="img-fluid rounded shadow-sm border" alt="RKBMN UI">
                            <p class="small text-muted mt-2">Gambar 7.1: Dashboard Perencanaan (RKBMN)</p>
                        </div>

                        <h6><strong>Langkah Pengajuan Usulan:</strong></h6>
                        <ol class="small">
                            <li>Buka menu <strong>PERENCANAAN (RKBMN) > Usulan Pengadaan</strong>.</li>
                            <li>Klik <strong>"Buat Usulan Baru"</strong>.</li>
                            <li>Pilih <strong>Kategori Barang</strong> yang dibutuhkan.</li>
                            <li>Isi <strong>Jumlah</strong>, <strong>Harga Satuan</strong>, dan <strong>Alasan Kebutuhan</strong>.</li>
                            <li>Klik <strong>Kirim Usulan</strong>. Usulan akan masuk ke antrean verifikasi Super Admin.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- 8. WASDAL -->
            <div class="tab-pane fade" id="wasdal">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-primary">8. Pengawasan (WASDAL)</h3>
                    </div>
                    <div class="card-body">
                        <p>Monitoring aset agar tidak ada barang yang terbengkalai (Idle).</p>

                        <div class="text-center mb-4">
                            <img src="{{ asset('img/guide/wasdal_detail.png') }}" class="img-fluid rounded shadow-sm border" alt="Wasdal Detail">
                            <p class="small text-muted mt-2">Gambar 8.1: Antarmuka Monitoring & Pelaporan Wasdal</p>
                        </div>

                        <h6><strong>SOP Monitoring & Pelaporan:</strong></h6>
                        <ol class="small">
                            <li><strong>Pelaporan:</strong> Menu <code>Pelaporan Wasdal</code> > Pilih tahun > Klik <code>Generate</code>. Sistem akan membuat laporan PDF siap cetak.</li>
                            <li><strong>Monitoring Idle:</strong> Menu <code>Monitoring & Idle</code>. Jika ada barang bertanda merah, artinya barang tersebut ada di database tapi tidak pernah digunakan/dipinjam dalam waktu lama. Segera lakukan pengecekan fisik!</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- 9. QR Code -->
            <div class="tab-pane fade" id="qr-code">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-primary">9. Penggunaan QR Code</h3>
                    </div>
                    <div class="card-body">
                        <p>Memudahkan audit lapangan hanya dengan smartphone.</p>

                        <div class="text-center mb-4">
                            <img src="{{ asset('img/guide/qr_scanner.png') }}" class="img-fluid rounded shadow-sm border" alt="QR Scanner">
                            <p class="small text-muted mt-2">Gambar 9.1: Proses Pemindaian QR Code Aset</p>
                        </div>

                        <h6><strong>Langkah Audit Cepat:</strong></h6>
                        <ol class="small">
                            <li>Tempelkan label QR Code pada aset fisik.</li>
                            <li>Buka menu <strong>Scan QR</strong> pada aplikasi via HP.</li>
                            <li>Arahkan kamera ke kode QR.</li>
                            <li>Klik link yang muncul. Detail aset (Nama, Lokasi, Kondisi) akan langsung tampil di layar HP Anda tanpa perlu mengetik apapun.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- 10. Update Sistem -->
            <div class="tab-pane fade" id="update">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold text-primary">10. Pembaruan Sistem (System Update)</h3>
                    </div>
                    <div class="card-body">
                        <p>Menjamin sistem Anda selalu memiliki fitur terbaru dan keamanan yang ditingkatkan.</p>
                        <ol class="small">
                            <li>Masuk ke menu <strong>Update Sistem</strong>.</li>
                            <li>Klik <strong>"Cek Pembaruan"</strong>. Tunggu indikator selesai berputar.</li>
                            <li>Baca <strong>Log Perubahan</strong> untuk melihat fitur apa yang baru ditambahkan oleh pengembang.</li>
                            <li>Jika ada update, klik tombol hijau <strong>"Perbarui Sistem"</strong>.</li>
                            <li>Tunggu hingga muncul pesan <span class="text-success">"Sistem Berhasil Diperbarui"</span>. Halaman akan otomatis refresh.</li>
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
        padding: 12px 15px;
        color: #495057;
        font-weight: 500;
        border-bottom: 1px solid rgba(0,0,0,.05);
        transition: all 0.3s;
        font-size: 0.9rem;
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
        padding: 15px;
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
    .xsmall {
        font-size: 0.75rem;
    }
</style>
@stop
