<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function show($slug)
    {
        $features = [
            'master' => [
                'title' => 'Master Data & Organisasi',
                'icon' => 'fas fa-sitemap',
                'description' => 'Pondasi utama tata kelola aset yang terstruktur dan hierarkis.',
                'content' => 'Modul Master Data memungkinkan pengelolaan entitas dasar seperti unit kerja, kategori aset, dan hak akses pengguna secara terpusat. Dengan sistem ini, standarisasi data di seluruh level organisasi dapat terjaga dengan baik.',
                'details' => [
                    'Manajemen Unit Kerja bertingkat',
                    'Kategorisasi aset sesuai standar kementerian',
                    'Manajemen Pengguna & Role (RBAC)',
                    'Log aktivitas sistem yang komprehensif'
                ]
            ],
            'aset' => [
                'title' => 'Manajemen Aset Tetap',
                'icon' => 'fas fa-boxes',
                'description' => 'Kelola seluruh aset fisik instansi dengan presisi tinggi.',
                'content' => 'Modul ini menangani siklus hidup aset tetap mulai dari perolehan, pencatatan (Tanah, Gedung, Peralatan), hingga monitoring kondisi fisik secara berkala. Seluruh data telah disesuaikan dengan skema SIMAN v2.',
                'details' => [
                    'Inventarisasi Tanah, Gedung, & Bangunan',
                    'Pencatatan Peralatan dan Mesin',
                    'Labeling Aset dengan QR Code',
                    'Monitoring kondisi aset (Baik, Rusak Ringan, Rusak Berat)'
                ]
            ],
            'persediaan' => [
                'title' => 'Aset Lancar / Persediaan',
                'icon' => 'fas fa-dolly-flatbed',
                'description' => 'Kontrol stok barang persediaan secara real-time dan akurat.',
                'content' => 'Modul Persediaan dirancang untuk mengelola barang habis pakai dan aset lancar lainnya. Memastikan ketersediaan stok untuk mendukung operasional harian tanpa resiko pemborosan atau kehilangan.',
                'details' => [
                    'Manajemen Stok Masuk & Keluar',
                    'Sistem Opname Fisik digital',
                    'Notifikasi ambang batas stok minimum',
                    'Pelaporan mutasi barang persediaan'
                ]
            ],
            'rkbmn' => [
                'title' => 'Perencanaan (RKBMN)',
                'icon' => 'fas fa-calendar-alt',
                'description' => 'Perencanaan kebutuhan aset yang strategis dan efisien.',
                'content' => 'RKBMN (Rencana Kebutuhan Barang Milik Negara) membantu instansi dalam merencanakan pengadaan dan pemeliharaan aset untuk tahun mendatang berdasarkan analisis kebutuhan riil dan ketersediaan anggaran.',
                'details' => [
                    'Penyusunan Rencana Kebutuhan Pengadaan',
                    'Perencanaan Pemeliharaan Aset Tahunan',
                    'Analisis Kebutuhan berdasarkan SBS',
                    'Ekspor data sesuai standar DJKN'
                ]
            ],
            'wasdal' => [
                'title' => 'Wasdal & Portofolio',
                'icon' => 'fas fa-shield-alt',
                'description' => 'Pengawasan dan pengendalian aset untuk optimalisasi nilai.',
                'content' => 'Wasdal (Pengawasan dan Pengendalian) memastikan aset digunakan sesuai peruntukannya. Modul Portofolio membantu dalam menganalisis utilitas aset untuk memaksimalkan pemanfaatan Barang Milik Negara.',
                'details' => [
                    'Monitoring penggunaan aset oleh unit kerja',
                    'Audit internal aset secara berkala',
                    'Manajemen asuransi & legalitas aset',
                    'Analisis utilitas & optimasi portofolio'
                ]
            ],
            'laporan' => [
                'title' => 'Laporan & Monitoring',
                'icon' => 'fas fa-file-invoice',
                'description' => 'Dashboard analitik untuk pengambilan keputusan yang tepat.',
                'content' => 'Sediakan laporan otomatis yang siap digunakan untuk kebutuhan audit dan rekonsiliasi. Dashboard interaktif memberikan visualisasi data aset secara real-time bagi pimpinan.',
                'details' => [
                    'Dashboard Executive Summary',
                    'Laporan Rekonsiliasi Internal/Eksternal',
                    'Cetak Laporan sesuai format standar',
                    'Ekspor data ke Excel & PDF'
                ]
            ]
        ];

        if (!isset($features[$slug])) {
            abort(404);
        }

        $feature = $features[$slug];
        return view('features.show', compact('feature'));
    }
}
