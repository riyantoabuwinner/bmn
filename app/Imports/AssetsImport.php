<?php

namespace App\Imports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Collection;

class AssetsImport implements ToCollection, WithHeadingRow, WithChunkReading, SkipsEmptyRows, \Maatwebsite\Excel\Concerns\WithEvents
{
    public $importId;

    public function __construct($importId = null)
    {
        $this->importId = $importId;
    }

    public function collection(Collection $rows)
    {
        $batch = [];
        $now = now();

        $optionalFieldsMapping = [
            'status_pemanfaatan' => 'status_penggunaan',
            'status_bmn' => 'status_bmn',
            'masa_manfaat' => 'umur_aset',
            'sisa_masa_manfaat' => 'sisa_umur_aset',
            'intra_ekstra' => 'intra_ekstra',
            'extra_info' => 'extra_info',
            'henti_guna' => 'henti_guna',
            'status_sbsn' => 'status_sbsn',
            'status_bmn_idle' => 'status_bmn_idle',
            'status_kemitraan' => 'status_kemitraan',
            'bpybds' => 'bpybds',
            'usulan_barang_hilang' => 'usulan_barang_hilang',
            'usulan_barang_rb' => 'usulan_barang_rb',
            'usulan_rusak_berat' => 'usulan_rusak_berat',
            'usulan_hapus' => 'usul_hapus',
            'hibah_dktp' => 'hibah_dktp',
            'konsensi_jasa' => 'konsensi_jasa',
            'properti_investasi' => 'properti_investasi',
            'jenis_dokumen' => 'jenis_dokumen',
            'no_dokumen' => 'no_dokumen',
            'tgl_dokumen' => 'tanggal_dokumen',
            'no_bpkp' => 'no_bpkp',
            'no_polisi' => 'no_polisi',
            'status_sertifikasi' => 'status_sertifikasi',
            'jenis_sertifikat' => 'jenis_sertifikat',
            'no_sertifikat' => 'no_sertifikat',
            'tgl_sertifikat' => 'tanggal_sertifikat',
            'masa_berlaku' => 'masa_berlaku',
            'nama_pemegang_hak' => 'nama_pemegang_hak',
            'nama_sertifikat' => 'nama', 
            'tgl_buku_pertama' => 'tanggal_buku_pertama',
            'tgl_pengapusan' => 'tanggal_pengapusan',
            'nilai_perolehan_pertama' => 'nilai_perolehan_pertama',
            'nilai_mutasi' => 'nilai_mutasi',
            'nilai_penyusutan' => 'nilai_penyusutan',
            'luas' => 'luas_tanah_seluruhnya',
            'luas_tanah_bangunan' => 'luas_tanah_untuk_bangunan',
            'luas_tanah_sarana' => 'luas_tanah_untuk_sarana_lingkungan',
            'luas_lahan_kosong' => 'luas_lahan_kosong',
            'lahan_kosong' => 'lahan_kosong',
            'luas_bangunan' => 'luas_bangunan',
            'luas_tapak_bangunan' => 'luas_tapak_bangunan',
            'luas_pemanfaatan' => 'luas_pemanfaatan',
            'jumlah_lantai' => 'jumlah_lantai',
            'jumlah_foto' => 'jumlah_foto',
            'no_psp' => 'no_psp',
            'tgl_psp' => 'tanggal_psp',
            'alamat' => 'alamat',
            'rt_rw' => 'rt_rw',
            'desa_kel' => 'kelurahan_desa',
            'kecamatan' => 'kecamatan',
            'kab_kota' => 'kab_kota',
            'kode_kab_kota' => 'kode_kab_kota',
            'provinsi' => 'provinsi',
            'kode_provinsi' => 'kode_provinsi',
            'kode_pos' => 'kode_pos',
            'sbsk' => 'sbsk',
            'optimalisasi' => 'optimalisasi',
            'penghuni' => 'penghuni',
            'pengguna' => 'pengguna',
            'kode_kpknl' => 'kode_kpknl',
            'uraian_kpknl' => 'uraian_kpknl',
            'uraian_kanwil' => 'uraian_kanwil_djkn',
            'nama_kl' => 'nama_k_l',
            'nama_e1' => 'nama_e1',
            'nama_korwil' => 'nama_korwil',
            'kode_register' => 'kode_register',
            'lokasi_ruang' => 'lokasi_ruang',
            'jenis_identitas' => 'jenis_identitas',
            'no_identitas' => 'no_identitas',
            'no_stnk' => 'no_stnk',
            'nama_pengguna_siman' => 'nama_pengguna',
            'status_pmk' => 'status_pmk'
        ];

        // Cache date fields list outside the loop for performance
        $dateFields = [];
        foreach ($optionalFieldsMapping as $dbField => $excelKey) {
            if (str_starts_with($dbField, 'tgl_') || str_starts_with($excelKey, 'tanggal_')) {
                $dateFields[$dbField] = true;
            }
        }

        foreach ($rows as $row) {
            $kodeBarang = $row['kode_barang'] ?? $row['kode_bmn'] ?? null;
            $nup = $row['nup'] ?? $row['no_nup'] ?? null;

            if (empty($kodeBarang)) continue;

            $merk = $row['merk'] ?? '';
            $tipe = $row['tipe'] ?? $row['type'] ?? '';

            $data = [
                'kode_satker' => $row['kode_satker'] ?? null,
                'nama_satker' => $row['nama_satker'] ?? null,
                'kode_barang' => $kodeBarang,
                'nama_barang' => $row['nama_barang'] ?? $row['uraian_barang'] ?? $row['nama_bmn'] ?? null,
                'nup' => $nup,
                'merk' => $merk,
                'tipe' => $tipe,
                'kondisi' => $row['kondisi'] ?? 'Baik',
                'status_pemanfaatan' => $row['status_penggunaan'] ?? $row['status_pemanfaatan'] ?? null,
                'status_bmn' => $row['status_bmn'] ?? null,
                'tgl_perolehan_pertama' => $this->transformDate($row['tgl_perolehan'] ?? $row['tanggal_perolehan'] ?? null),
                'nilai_perolehan' => $row['nilai_perolehan'] ?? 0,
                'nilai_buku' => $row['nilai_buku'] ?? $row['book_value'] ?? 0,
                'kuantitas' => $row['kuantitas'] ?? 1,
                'satuan' => $row['satuan'] ?? 'Unit',
                'lokasi' => $row['lokasi'] ?? null,
                'qr_code' => $row['qr_code'] ?? ($kodeBarang . '.' . $nup),
                'updated_at' => $now,
            ];

            $numericFields = [
                'nilai_perolehan', 'nilai_buku', 'nilai_perolehan_pertama', 'nilai_mutasi', 
                'nilai_penyusutan', 'masa_manfaat', 'sisa_masa_manfaat', 'kuantitas', 
                'luas', 'luas_tanah_bangunan', 'luas_tanah_sarana', 'luas_lahan_kosong',
                'luas_bangunan', 'luas_tapak_bangunan', 'luas_pemanfaatan', 'jumlah_lantai', 'jumlah_foto'
            ];

            foreach ($optionalFieldsMapping as $dbField => $excelKey) {
                if (isset($row[$excelKey])) {
                    $val = $row[$excelKey];
                    if (isset($dateFields[$dbField])) {
                        $data[$dbField] = $this->transformDate($val);
                    } elseif (in_array($dbField, $numericFields)) {
                        $data[$dbField] = $this->transformNumber($val);
                    } else {
                        $data[$dbField] = $val;
                    }
                } elseif (in_array($dbField, $numericFields)) {
                    $data[$dbField] = 0;
                }
            }

            // Ensure unique_asset_id for new records (since upsert skips boot())
            $data['unique_asset_id'] = $row['unique_asset_id'] ?? 'BMN-' . strtoupper(\Illuminate\Support\Str::random(8)) . '-' . date('Y');
            $data['created_at'] = $now;

            $batch[] = $data;
        }

        if (!empty($batch)) {
            // Get columns to update (everything except created_at and unique keys)
            $updateColumns = array_diff(array_keys($batch[0]), ['unique_asset_id', 'created_at']);
            
            // Bulk upsert for maximum performance
            // Matches by kode_barang and nup
            Asset::upsert($batch, ['kode_barang', 'nup'], $updateColumns);

            if ($this->importId) {
                $processed = \Cache::increment("import_processed_{$this->importId}", count($batch));
                $oldCount = $processed - count($batch);

                \Log::info("AssetImportProgressUpdate: ID={$this->importId}, Old={$oldCount}, New={$processed}, Batch=" . count($batch));

                // Fallback: if processed exceeds total, update total
                $total = \Cache::get("import_total_{$this->importId}", 0);
                if ($processed > $total) {
                    \Cache::put("import_total_{$this->importId}", $processed, now()->addHours(2));
                }
            }
        }
    }

    public function chunkSize(): int
    {
        return 500; // Reduced from 1000 to lower memory usage
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\BeforeImport::class => function (\Maatwebsite\Excel\Events\BeforeImport $event) {
                if ($this->importId) {
                    \Cache::put("import_status_{$this->importId}", 'counting', now()->addHours(2));
                    \Log::info("AssetImport BeforeImport: Counting rows for ID={$this->importId}");
                    
                    try {
                        $totalRows = $event->reader->getTotalRows();
                        $total = 0;
                        if (!empty($totalRows)) {
                            // Take the largest number of rows from any sheet to be safe
                            $total = max(array_values($totalRows)) - 1;
                            if ($total < 0) $total = 0;
                        }
                        \Cache::put("import_total_{$this->importId}", $total, now()->addHours(2));
                        \Cache::put("import_processed_{$this->importId}", 0, now()->addHours(2));
                        \Cache::put("import_status_{$this->importId}", 'running', now()->addHours(2));
                    } catch (\Exception $e) {
                        \Log::error("Error counting rows: " . $e->getMessage());
                        \Cache::put("import_total_{$this->importId}", 0, now()->addHours(2));
                        \Cache::put("import_status_{$this->importId}", 'running', now()->addHours(2));
                    }
                }
            },
        ];
    }

    private function transformNumber($value)
    {
        if (is_null($value) || $value === '') return 0;
        if (is_numeric($value)) return $value;
        
        // Handle formatted numbers like "1.234.567,89"
        $val = str_replace(['.', ','], ['', '.'], $value);
        return is_numeric($val) ? (float) $val : 0;
    }

    private function transformDate($value)
    {
        if (empty($value))
            return null;
        try {
            // If it's a numeric value (Excel serial date)
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value);
            }
            // If it's already a string date, try parsing
            return \Carbon\Carbon::parse($value);
        } catch (\Exception $e) {
            return null;
        }
    }
}
