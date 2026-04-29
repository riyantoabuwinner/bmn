<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tanah',
                'description' => 'Aset berupa lahan atau tanah (Kampus, Kebun Percobaan, dll).'
            ],
            [
                'name' => 'Gedung dan Bangunan',
                'description' => 'Bangunan gedung tempat kerja, gedung perkuliahan, rumah dinas, dll.'
            ],
            [
                'name' => 'Alat Angkutan',
                'description' => 'Kendaraan bermotor dan alat transportasi lainnya (Mobil, Motor, Bus).'
            ],
            [
                'name' => 'Alat Besar',
                'description' => 'Peralatan besar untuk konstruksi atau keperluan khusus (Traktor, Excavator, Genset Besar).'
            ],
            [
                'name' => 'Alat Laboratorium',
                'description' => 'Peralatan pendukung kegiatan praktikum dan penelitian.'
            ],
            [
                'name' => 'Alat Persenjataan',
                'description' => 'Khusus untuk instansi yang memiliki izin persenjataan (Satpam/Polisi Kampus).'
            ],
            [
                'name' => 'Alat Kedokteran dan Kesehatan',
                'description' => 'Peralatan medis untuk Rumah Sakit Pendidikan atau Poliklinik.'
            ],
            [
                'name' => 'Alat Studio dan Komunikasi',
                'description' => 'Peralatan audio visual, pemancar, dan alat komunikasi (Kamera, Mixer, HT).'
            ],
            [
                'name' => 'Peralatan Komputer dan TIK',
                'description' => 'PC, Laptop, Server, Printer, dan perangkat jaringan.'
            ],
            [
                'name' => 'Alat Kantor dan Rumah Tangga',
                'description' => 'Meubelair (Meja/Kursi), AC, Kipas Angin, Lemari, dan perabot lainnya.'
            ],
            [
                'name' => 'Alat Bengkel dan Ukur',
                'description' => 'Peralatan teknis perbengkelan dan alat ukur teknik.'
            ],
            [
                'name' => 'Alat Pertanian dan Peternakan',
                'description' => 'Peralatan pendukung studi pertanian/peternakan.'
            ],
            [
                'name' => 'Buku dan Perpustakaan',
                'description' => 'Koleksi buku, jurnal, dan bahan pustaka lainnya.'
            ],
            [
                'name' => 'Barang Bercorak Kesenian',
                'description' => 'Lukisan, patung, dan benda seni lainnya.'
            ],
            [
                'name' => 'Hewan',
                'description' => 'Hewan ternak, hewan percobaan, atau hewan penjaga.'
            ],
            [
                'name' => 'Jalan, Irigasi, dan Jaringan',
                'description' => 'Infrastruktur jalan, jembatan, saluran air, dan jaringan instalasi.'
            ],
            [
                'name' => 'Konstruksi Dalam Pengerjaan (KDP)',
                'description' => 'Aset yang masih dalam tahap pembangunan.'
            ],
            [
                'name' => 'Aset Tetap Lainnya',
                'description' => 'Aset yang tidak masuk dalam klasifikasi di atas.'
            ],
        ];

        foreach ($categories as $cat) {
            \App\Models\AssetCategory::firstOrCreate(
            ['name' => $cat['name']],
            ['description' => $cat['description']]
            );
        }
    }
}
