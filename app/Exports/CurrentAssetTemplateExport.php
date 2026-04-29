<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CurrentAssetTemplateExport implements WithHeadings, WithTitle
{
    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Kategori',
            'Stok Awal',
            'Stok Minimum',
            'Satuan',
            'Harga Satuan',
            'Tanggal Perolehan (YYYY-MM-DD)',
            'Sumber Dana',
            'Lokasi Penyimpanan',
            'Spesifikasi',
            'Keterangan',
            'Unit',
        ];
    }

    public function title(): string
    {
        return 'Template Import Aset Lancar';
    }
}
