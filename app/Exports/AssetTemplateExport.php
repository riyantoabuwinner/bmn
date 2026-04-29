<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class AssetTemplateExport implements WithHeadings, WithTitle
{
    public function headings(): array
    {
        return [
            'Kode Satker', 'Nama Satker', 'Kode Barang', 'Nama Barang', 'Jenis BMN', 'NUP', 'Merk/Type', 'Kondisi', 'Status Penggunaan',
            'Status BMN', 'Status SBSN', 'Status BMN Idle', 'Status Kemitraan', 'TGR',
            'Tgl Perolehan', 'Tgl Pembukuan', 'Tgl Buku Pertama', 'Tgl Reval', 'Tgl Penghapusan', 'Tgl PSP', 'Tahun Perolehan',
            'Nilai Perolehan Pertama', 'Nilai Mutasi', 'Nilai Perolehan', 'Nilai Penyusutan', 'Nilai Buku', 'Nilai Buku (App)', 'Nilai Penyusutan (App)', 'Akumulasi Penyusutan',
            'Kuantitas', 'Satuan', 'Luas Tanah Seluruhnya', 'Luas Tanah Bangunan', 'Luas Tanah Sarana', 'Luas Lahan Kosong', 'Luas Bangunan', 'Luas Tapak Bangunan', 'Luas Pemanfaatan', 'Luas Tanah (App)', 'Luas Bangunan (App)', 'Jumlah Lantai',
            'Lokasi', 'Alamat', 'RT/RW', 'Desa/Kel', 'Kecamatan', 'Kab/Kota', 'Kode Kab/Kota', 'Provinsi', 'Kode Provinsi', 'Kode Pos',
            'Umur Ekonomis', 'No PSP', 'No SIP/Polisi', 'SBSK', 'Optimalisasi', 'Penghuni', 'Pengguna Barang', 'Kode KPKNL', 'Uraian KPKNL', 'Uraian Kanwil', 'Nama KL', 'Nama E1', 'Nama Korwil', 'Kode Register', 'Cara Perolehan', 'No Bukti', 'Keterangan',
            'No Rangka', 'No Mesin', 'Bahan Bakar', 'Warna', 'Kapasitas Mesin',
            'QR Code', 'Unit ID', 'Category ID', 'Location ID'
        ];
    }

    public function title(): string
    {
        return 'Template Import Aset';
    }
}
