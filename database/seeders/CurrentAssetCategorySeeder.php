<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CurrentAssetCategory;

class CurrentAssetCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Barang Konsumsi',
                'description' => 'Barang yang habis pakai seperti alat tulis kantor (ATK), bahan pembersih, konsumsi rapat, dan bahan bakar.',
            ],
            [
                'name' => 'Bahan untuk Pemeliharaan',
                'description' => 'Bahan yang digunakan untuk pemeliharaan/perbaikan yang tidak menambah masa manfaat aset tetap.',
            ],
            [
                'name' => 'Suku Cadang',
                'description' => 'Komponen atau sparepart untuk pemeliharaan peralatan, mesin, dan kendaraan dinas.',
            ],
            [
                'name' => 'Bahan Baku',
                'description' => 'Bahan yang digunakan dalam proses produksi untuk menghasilkan barang lain.',
            ],
            [
                'name' => 'Barang dalam Proses',
                'description' => 'Aset yang sedang dalam proses produksi dan belum selesai pengerjaannya.',
            ],
            [
                'name' => 'Persediaan untuk Dijual/Diserahkan',
                'description' => 'Barang yang diadakan dengan tujuan hibah, bantuan sosial, atau dijual kepada pihak ketiga/masyarakat.',
            ],
        ];

        foreach ($categories as $category) {
            CurrentAssetCategory::firstOrCreate(
            ['name' => $category['name']],
            ['description' => $category['description']]
            );
        }
    }
}
