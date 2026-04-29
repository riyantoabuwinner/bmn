<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetCategoryReassignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mappings = [
            'Tanah' => ['Tanah'],
            'Gedung dan Bangunan' => [
                'Gedung', 'Bangunan', 'Rumah', 'Asrama', 'Pos Jaga', 'Garasi',
                'Klinik', 'Laboratorium', 'Masjid', 'Musholla', 'Gudang'
            ],
            'Alat Angkutan' => [
                'Mobil', 'Motor', 'Sepeda', 'Bus', 'Truk', 'Ambulance', 'Pick Up', 'Minibus', 'Sedan'
            ],
            'Alat Besar' => [
                'Traktor', 'Excavator', 'Forklift', 'Crane', 'Genset Besar', 'Diesel', 'Mesin Giling'
            ],
            'Alat Laboratorium' => [
                'Mikroskop', 'Tester', 'Alat Uji', 'Centrifuge', 'Oven Lab', 'Autoclave',
                'Timbangan Analitik', 'Spectrophotometer', 'Apparatus', 'Alat Peraga'
            ],
            'Alat Persenjataan' => [
                'Senjata', 'Pistol'
            ],
            'Alat Kedokteran dan Kesehatan' => [
                'Stetoskop', 'Tensi', 'Kursi Roda', 'Bed Pasien', 'Dental Unit', 'USG',
                'Rontgen', 'Alat Bedah', 'Tabung Oksigen'
            ],
            'Alat Studio dan Komunikasi' => [
                'Kamera', 'Handycam', 'Televisi', 'TV', 'Projector', 'Infocus', 'Layar',
                'Screen', 'Speaker', 'Sound', 'Microphone', 'Mixer Audio', 'Amplifier',
                'Walkie Talkie', 'HT', 'Radio', 'Antena'
            ],
            'Peralatan Komputer dan TIK' => [
                'Komputer', 'PC', 'CPU', 'Laptop', 'Notebook', 'Server', 'Printer',
                'Scanner', 'Monitor', 'Keyboard', 'Mouse', 'Harddisk', 'Flashdisk',
                'Switch', 'Hub', 'Router', 'Modem', 'Access Point', 'UPS', 'Stabilizer'
            ],
            'Alat Kantor dan Rumah Tangga' => [
                'Meja', 'Kursi', 'Lemari', 'Rak', 'Filing', 'Locker', 'Brankas', 'Sofa',
                'AC', 'Air Conditioning', 'Kipas Angin', 'Exhaust Fan', 'Dispenser', 'Kulkas',
                'Mesin Cuci', 'Kompor', 'Tabung Gas', 'Jam Dinding', 'Papan Tulis', 'White Board',
                'Mesin Tik', 'Mesin Hitung', 'Kalkulator', 'Calculator', 'Mesin Fotocopy',
                'Mesin Laminating', 'Mesin Penghancur Kertas', 'Paper Shredder', 'Pintu', 'Jendela',
                'Gorden', 'Karpet', 'Ambal', 'Tangga', 'Partisi'
            ],
            'Alat Bengkel dan Ukur' => [
                'Bor', 'Gerinda', 'Gergaji', 'Tang', 'Obeng', 'Kunci Pas', 'Kunci Ring',
                'Mesin Las', 'Compressor', 'Dongkrak', 'Multitester', 'Oscilloscope'
            ],
            'Alat Pertanian dan Peternakan' => [
                'Hand Tractor', 'Bajak', 'Semprotan Hama', 'Kandang'
            ],
            'Buku dan Perpustakaan' => [
                'Buku', 'Majalah', 'Jurnal', 'Peta', 'Globe'
            ],
            'Barang Bercorak Kesenian' => [
                'Lukisan', 'Patung', 'Guci', 'Kaligrafi'
            ],
            'Jalan, Irigasi, dan Jaringan' => [
                'Jalan', 'Jembatan', 'Saluran', 'Irigasi', 'Pagar', 'Tiang Listrik', 'Gardu Listrik'
            ]
        ];

        foreach ($mappings as $categoryName => $keywords) {
            $category = \App\Models\AssetCategory::where('name', $categoryName)->first();

            if ($category) {
                foreach ($keywords as $keyword) {
                    $count = \App\Models\AsetTetap::where('name', 'like', '%' . $keyword . '%')
                        ->update(['category_id' => $category->id]);

                    if ($count > 0) {
                        $this->command->info("Updated {$count} assets to category '{$categoryName}' with keyword '{$keyword}'");
                    }
                }
            }
            else {
                $this->command->error("Category '{$categoryName}' not found.");
            }
        }
    }
}
