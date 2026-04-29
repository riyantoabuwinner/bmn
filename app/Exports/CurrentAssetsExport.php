<?php

namespace App\Exports;

use App\Models\CurrentAsset;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CurrentAssetsExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return CurrentAsset::query();
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Kategori',
            'Stok Awal',
            'Stok Masuk',
            'Stok Keluar',
            'Stok Tersedia',
            'Stok Minimum',
            'Satuan',
            'Harga Satuan',
            'Nilai Total',
            'Tanggal Perolehan',
            'Sumber Dana',
            'Lokasi Penyimpanan',
            'Spesifikasi',
            'Keterangan',
            'Unit',
        ];
    }

    public function map($asset): array
    {
        return [
            $asset->kode_barang,
            $asset->nama_barang,
            $asset->kategori,
            $asset->stok_awal,
            $asset->stok_masuk,
            $asset->stok_keluar,
            $asset->stok_tersedia,
            $asset->stok_minimum,
            $asset->satuan,
            $asset->harga_satuan,
            $asset->nilai_total,
            $asset->tanggal_perolehan ? $asset->tanggal_perolehan->format('Y-m-d') : null,
            $asset->sumber_dana,
            $asset->lokasi_penyimpanan,
            $asset->spesifikasi,
            $asset->keterangan,
            $asset->unit ? $asset->unit->name : null,
        ];
    }
}
