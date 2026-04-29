<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetLocation;
use App\Models\Unit;
use Carbon\Carbon;

class BmnImportSeederV3 extends Seeder
{
    public function run(): void
    {
        $filePath = storage_path('app/bmn_assets_new.csv');

        if (!file_exists($filePath)) {
            $this->command->error("File import BMN assets tidak ditemukan di: {$filePath}");
            return;
        }

        $this->command->info("Memulai import BMN assets V3 FULL dari {$filePath}...");
        try {
            $this->command->info("Database Connection: " . DB::connection()->getDatabaseName());
        } catch (\Exception $e) {
             // ignore
        }

        try {
            $count = $this->importCsv($filePath);
            $this->command->info("Berhasil mengimport {$count} aset BMN dan memperbarui Master Data!");
        } catch (\Exception $e) {
            $this->command->error("Gagal mengimport: " . $e->getMessage());
            Log::error($e);
        }
    }

    private function importCsv(string $filePath)
    {
        $handle = fopen($filePath, 'r');
        if (!$handle) {
            throw new \Exception("Could not open file: {$filePath}");
        }

        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            throw new \Exception("File is empty or invalid CSV");
        }

        $header[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $header[0]);
        $header = array_map('trim', $header);
        $map = array_flip($header);
        
        $required = ['Kode Barang', 'NUP', 'Nama Barang'];
        foreach ($required as $col) {
            if (!isset($map[$col])) {
                throw new \Exception("Kolom wajib '{$col}' tidak ditemukan di CSV.");
            }
        }

        try {
            $count = 0;
            
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) < count($header)) continue; 
                
                $getData = function($colName) use ($row, $map) {
                    return isset($map[$colName]) ? trim($row[$map[$colName]]) : null;
                };

                $categoryName = $getData('Jenis BMN') ?: 'Uncategorized';
                $category = AssetCategory::firstOrCreate(['name' => $categoryName], ['description' => 'Imported']);

                $unitName = $getData('Nama Satker') ?: 'Unknown Unit';
                $unit = Unit::firstOrCreate(['name' => $unitName], ['type' => 'unit_kerja']);

                $locationName = $getData('Lokasi Ruang');
                if (empty($locationName) || $locationName === '-' || strtolower($locationName) === 'belum berlokasi') {
                    $locationName = 'Gudang Utama';
                }
                $location = AssetLocation::firstOrCreate(['name' => $locationName, 'unit_id' => $unit->id]);

                $kodeBarang = $getData('Kode Barang');
                $nup = $getData('NUP');
                $namaBarang = $getData('Nama Barang');
                $merk = $getData('Merk');
                $tipe = $getData('Tipe');
                $merkType = trim("$merk $tipe");
                $kodeSatker = $getData('Kode Satker');
                
                $tglPerolehan = $this->parseDate($getData('Tanggal Perolehan'));
                $nilaiPerolehan = $this->parseValue($getData('Nilai Perolehan'));
                
                $kondisiRaw = strtolower($getData('Kondisi') ?? '');
                $kondisi = match(true) {
                    str_contains($kondisiRaw, 'ringan') => 'Rusak Ringan',
                    str_contains($kondisiRaw, 'berat') => 'Rusak Berat',
                    default => 'Baik'
                };

                $statusRaw = $getData('Status Penggunaan');
                $statusPenggunaan = $statusRaw ?: 'Digunakan';

                $asset = Asset::where('kode_barang', $kodeBarang)->where('nup', $nup)->first();
                
                if ($asset) {
                    $asset->jenis_bmn = $categoryName;
                    $asset->category_id = $category->id;
                    $asset->save();
                    
                    if ($count <= 5 || $count % 1000 === 0) {
                        $this->command->info("Row {$count} Updated: ID {$asset->id} JenisBMN: {$categoryName}");
                    }
                } else {
                    $asset = Asset::create([
                        'kode_barang' => $kodeBarang,
                        'nup' => $nup,
                        'nama_barang' => $namaBarang,
                        'merk_type' => $merkType,
                        'kondisi' => $kondisi,
                        'nilai_perolehan' => $nilaiPerolehan,
                        'tgl_perolehan' => $tglPerolehan,
                        'kode_satker' => $kodeSatker,
                        'nama_satker' => $unitName,
                        'lokasi' => $locationName, 
                        'status_penggunaan' => $statusPenggunaan,
                        'kuantitas' => 1,
                        'satuan' => 'Unit',
                        'jenis_bmn' => $categoryName,
                        'category_id' => $category->id,
                    ]);
                    
                    if ($count <= 5) {
                         $this->command->info("Row {$count} Created: JenisBMN: {$categoryName}");
                    }
                }

                $count++;
                if ($count % 1000 === 0) $this->command->info("Processed {$count} rows...");
            }
            fclose($handle);
            return $count;
        } catch (\Exception $e) {
            fclose($handle);
            throw $e;
        }
    }

    private function parseDate($dateStr) {
        if (empty($dateStr) || $dateStr === '-') return null;
        try { return Carbon::parse($dateStr); } catch (\Exception $e) { return null; }
    }

    private function parseValue($valStr) {
        if (empty($valStr) || $valStr === '-') return 0;
        $clean = preg_replace('/[^\d,]/', '', $valStr);
        $clean = str_replace(',', '.', $clean);
        return (float) $clean;
    }
}
