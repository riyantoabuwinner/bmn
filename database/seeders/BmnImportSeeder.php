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

class BmnImportSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = storage_path('app/bmn_assets.csv');
        if (!file_exists($filePath)) {
            $this->command->error("File import BMN assets tidak ditemukan di: {$filePath}");
            return;
        }
        $this->command->info("Memulai import BMN assets dari {$filePath}...");
        try {
            $count = $this->importCsv($filePath);
            $this->command->info("Berhasil mengimport {$count} aset BMN!");
        } catch (\Exception $e) {
            $this->command->error("Gagal mengimport: " . $e->getMessage());
            Log::error($e);
        }
    }
    private function importCsv(string $filePath)
    {
        $handle = fopen($filePath, 'r');
        if (!$handle) throw new \Exception("Could not open file: {$filePath}");
        $header = fgetcsv($handle);
        if (!$header) { fclose($handle); throw new \Exception("File is empty or invalid CSV"); }
        $header[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $header[0]);
        $map = array_flip($header);
        DB::beginTransaction();
        try {
            $count = 0;
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) < count($header)) continue; 
                $data = [];
                foreach ($map as $key => $index) $data[$key] = $row[$index] ?? null;
                $categoryName = $data['Jenis BMN'] ?: 'Uncategorized';
                $unitName = $data['Nama Satker'] ?: 'Unknown Unit';
                $locationName = $data['Lokasi Ruang'] ?: 'Gudang Utama'; 
                if (trim($locationName) === '' || strtolower($locationName) === 'belum berlokasi') $locationName = 'Gudang Utama';
                
                $category = AssetCategory::firstOrCreate(['name' => $categoryName], ['description' => 'Imported from BMN Sheet']);
                
                $unit = Unit::firstOrCreate(['name' => $unitName], ['type' => 'unit_kerja']);

                $location = AssetLocation::firstOrCreate(['name' => $locationName, 'unit_id' => $unit->id]);

                $assetCode = $data['Kode Barang'] . '.' . $data['NUP'];
                $purchaseDate = $this->parseDate($data['Tanggal Perolehan']);
                $purchaseValue = $this->parseValue($data['Nilai Perolehan']);
                $condition = strtolower($data['Kondisi'] ?? 'baik');
                $conditionStatus = match($condition) { 'baik' => 'baik', 'rusak ringan' => 'rusak_ringan', 'rusak berat' => 'rusak_berat', default => 'baik' };
                
                Asset::updateOrCreate(['asset_code' => $assetCode], [
                    'name' => $data['Nama Barang'] ?? 'Unnamed Asset', 'nup' => $data['NUP'], 'brand' => trim(($data['Merk'] ?? '') . ' ' . ($data['Tipe'] ?? '')),
                    'category_id' => $category->id, 'unit_id' => $unit->id, 'location_id' => $location->id,
                    'purchase_date' => $purchaseDate, 'fiscal_year' => $purchaseDate ? $purchaseDate->year : null, 'purchase_value' => $purchaseValue,
                    'source_of_funds' => 'APBN', 'condition_status' => $conditionStatus, 'availability_status' => 'tersedia', 'is_rentable' => false, 'is_borrowable' => false ]);
                $count++;
            }
            DB::commit(); fclose($handle); return $count;
        } catch (\Exception $e) { DB::rollBack(); fclose($handle); throw $e; }
    }
    private function parseDate($dateStr) {
        if (empty($dateStr) || $dateStr === '-') return Carbon::now();
        try { return Carbon::parse($dateStr); } catch (\Exception $e) { return Carbon::now(); }
    }
    private function parseValue($valStr) {
        if (empty($valStr) || $valStr === '-') return 0;
        return (float) preg_replace('/[^0-9\.]/', '', $valStr);
    }
}
