<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssetCategory;

class UpdateAssetCategoryDescriptionsSeeder extends Seeder
{
    public function run()
    {
        $definitions = [
            'TANAH' => 'Tanah yang diperoleh dengan tujuan untuk dipakai dalam kegiatan operasional pemerintah dan dalam kondisi siap pakai, baik yang ada bangunannya maupun tidak.',

            'BANGUNAN DAN GEDUNG' => 'Bangunan gedung tempat kerja, rumah dinas, dan bangunan lain yang diperoleh dengan tujuan untuk dipakai dalam kegiatan operasional pemerintah.',

            'JALAN DAN JEMBATAN' => 'Infrastruktur jalan dan jembatan yang dibangun dan dimiliki oleh negara untuk kepentingan umum atau pendukung operasional.',

            'BANGUNAN AIR' => 'Bangunan yang berfungsi untuk pengelolaan air, irigasi, bendungan, waduk, dan infrastruktur sumber daya air lainnya.',

            'INSTALASI DAN JARINGAN' => 'Infrastruktur jaringan listrik, telepon, internet, air bersih, gas, dan instalasi teknis lainnya yang menunjang fungsi bangunan atau wilayah.',

            'MESIN PERALATAN KHUSUS TIK' => 'Perangkat keras, infrastruktur teknologi informasi, komputer, server, dan perangkat jaringan yang mendukung digitalisasi pemerintahan.',

            'MESIN PERALATAN NON TIK' => 'Mesin dan peralatan operasional yang tidak termasuk dalam kategori teknologi informasi dan komunikasi (misal: genset, mesin fotokopi, AC, furnitur).',

            'ASET TETAP LAINNYA' => 'Aset tetap yang tidak dapat dikelompokkan ke dalam kategori tanah, mesin, gedung, atau jalan/jaringan (contoh: koleksi perpustakaan, barang bercorak kesenian).',

            'ASET TAK BERWUJUD' => 'Aset non-moneter yang dapat diidentifikasi namun tidak memiliki wujud fisik, seperti perangkat lunak (software), lisensi, hak cipta, dan hasil kajian.',

            'ALAT BESAR' => 'Peralatan mesin berukuran besar yang digunakan untuk kegiatan konstruksi, pertambangan, atau tugas berat lainnya (excavator, crane, traktor).',

            'ALAT ANGKUTAN BERMOTOR' => 'Kendaraan bermotor yang digunakan untuk perpindahan orang atau barang (mobil dinas, motor, truk, bus).',

            'ALAT PERSENJATAAN' => 'Peralatan dan mesin yang dikhususkan untuk keperluan pertahanan dan keamanan negara.',

            'PERALATAN DAN MESIN' => 'Mesin, kendaraan, alat elektronik, inventaris kantor, dan peralatan lainnya yang nilainya signifikan dan masa manfaatnya lebih dari 12 bulan.',

            'KONSTRUKSI DALAM PENGERJAAN' => 'Aset yang sedang dalam proses pembangunan atau renovasi dan belum siap digunakan sepenuhnya.',

            'ASET LAINNYA' => 'Aset tetap yang tidak dapat dikelompokkan ke dalam kategori tanah, mesin, gedung, atau jalan/jaringan (contoh: koleksi perpustakaan, barang bercorak kesenian).', // Some systems use this instead of ASET TETAP LAINNYA
            'HEWAN, IKAN DAN TUMBUHAN' => 'Hewan, ikan, dan tumbuhan yang dikembangbiakkan oleh pemerintah untuk tujuan konservasi, penelitian, atau produksi.',
        ];

        foreach ($definitions as $name => $description) {
            // Trim whitespace to be safe
            $targetName = trim($name);

            // Try updating with exact match after trimming
            $updated = AssetCategory::where('name', $targetName)->update(['description' => $description]);

            if ($updated === 0) {
                $this->command->warn("Category not found: {$targetName}");
            }
            else {
                $this->command->info("Updated: {$targetName}");
            }
        }
    }
}
