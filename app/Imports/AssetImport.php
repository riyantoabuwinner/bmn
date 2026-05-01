<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\ImportTask;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\ImportFailed;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use Illuminate\Contracts\Queue\ShouldQueue;

class AssetImport implements ToCollection, WithHeadingRow, WithChunkReading, WithEvents, SkipsEmptyRows, WithColumnLimit, ShouldQueue
{
    public $importTaskId;

    public function __construct($importTaskId)
    {
        $this->importTaskId = $importTaskId;
        // Reduced memory limit slightly to be more realistic, but keeping it high enough
        ini_set('memory_limit', '1G');
        set_time_limit(0);
    }

    public function collection(Collection $rows)
    {
        $batch = [];
        $now = now();

        foreach ($rows as $row) {
            $kodeBarang = $row['kode_barang'] ?? $row['kode_bmn'] ?? null;
            $nup = $row['nup'] ?? null;
            if (empty($kodeBarang) || is_null($nup)) continue;

            $batch[] = [
                'jenis_bmn' => $row['jenis_bmn'] ?? null,
                'kode_satker' => $row['kode_satker'] ?? null,
                'nama_satker' => $row['nama_satker'] ?? null,
                'kode_barang' => $kodeBarang,
                'nup' => (int) $nup,
                'nama_barang' => $row['nama_barang'] ?? $row['uraian_barang'] ?? null,
                'merk' => $row['merk'] ?? null,
                'tipe' => $row['tipe'] ?? null,
                'kondisi' => $row['kondisi'] ?? 'Baik',
                'umur_aset' => $row['umur_aset'] ?? null,
                'intra_ekstra' => $row['intra_ekstra'] ?? null,
                'kuantitas' => $row['kuantitas'] ?? 1,
                'satuan' => $row['satuan'] ?? 'Unit',
                'nilai_perolehan_pertama' => $this->parseNumber($row['nilai_perolehan_pertama_rp'] ?? $row['nilai_perolehan_pertama'] ?? 0),
                'akumulasi_penyusutan' => $this->parseNumber($row['akumulasi_penyusutan_rp'] ?? $row['akumulasi_penyusutan'] ?? 0),
                'nilai_buku' => $this->parseNumber($row['nilai_buku_rp'] ?? $row['nilai_buku'] ?? 0),
                'tgl_perolehan_pertama' => $this->parseDate($row['tanggal_perolehan_pertama'] ?? $row['tgl_perolehan'] ?? null),
                'tgl_buku' => $this->parseDate($row['tanggal_buku'] ?? $row['tgl_buku'] ?? null),
                'masa_manfaat' => $this->parseNumber($row['masa_manfaat'] ?? 0),
                'sisa_masa_manfaat' => $this->parseNumber($row['sisa_masa_manfaat'] ?? 0),
                'no_dokumen' => $row['no_dokumen'] ?? null,
                'tgl_dokumen' => $this->parseDate($row['tgl_dokumen'] ?? null),
                'no_psp' => $row['no_psp'] ?? null,
                'tgl_psp' => $this->parseDate($row['tgl_psp'] ?? null),
                'status_sbsn' => $row['status_sbsn'] ?? null,
                'status_bmn_idle' => $row['status_bmn_idle'] ?? null,
                'status_kemitraan' => $row['status_kemitraan'] ?? null,
                'bpybds' => $row['bpybds'] ?? null,
                'usulan_barang_hilang' => $row['usulan_barang_hilang'] ?? null,
                'usulan_barang_rb' => $row['usulan_barang_rb'] ?? null,
                'usulan_rusak_berat' => $row['usulan_rusak_berat'] ?? null,
                'usulan_hapus' => $row['usulan_hapus'] ?? null,
                'no_sertifikat' => $row['no_sertifikat'] ?? null,
                'nama_sertifikat' => $row['nama_sertifikat'] ?? $row['nama_pemilik'] ?? null,
                'tgl_sertifikat' => $this->parseDate($row['tgl_sertifikat'] ?? null),
                'masa_berlaku' => $this->parseDate($row['masa_berlaku'] ?? null),
                'nama_pemegang_hak' => $row['nama_pemegang_hak'] ?? null,
                'alamat' => $row['alamat'] ?? null,
                'rt_rw' => $row['rt_rw'] ?? null,
                'desa_kel' => $row['kelurahan_desa'] ?? $row['desa_kel'] ?? null,
                'kecamatan' => $row['kecamatan'] ?? null,
                'kab_kota' => $row['kab_kota'] ?? null,
                'provinsi' => $row['provinsi'] ?? null,
                'luas' => $this->parseNumber($row['luas_m2'] ?? $row['luas'] ?? 0),
                'luas_bangunan' => $this->parseNumber($row['luas_bangunan'] ?? 0),
                'luas_tapak_bangunan' => $this->parseNumber($row['luas_tapak_bangunan'] ?? 0),
                'luas_pemanfaatan' => $this->parseNumber($row['luas_pemanfaatan'] ?? 0),
                'jumlah_lantai' => $this->parseNumber($row['jumlah_lantai'] ?? 0),
                'jumlah_foto' => $this->parseNumber($row['jumlah_foto'] ?? 0),
                'status_pemanfaatan' => $row['status_pemanfaatan'] ?? $row['status_penggunaan'] ?? null,
                'lahan_kosong' => $row['lahan_kosong'] ?? null,
                'keterangan' => $row['keterangan'] ?? null,
                'unique_asset_id' => $row['unique_asset_id'] ?? 'BMN-' . strtoupper(\Illuminate\Support\Str::random(8)) . '-' . date('Y'),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($batch)) {
            Log::info("Processing batch for Task ID: " . ($this->importTaskId ?? 'NULL') . ". Rows: " . count($batch));
            
            $updateColumns = array_diff(array_keys($batch[0]), ['unique_asset_id', 'created_at']);
            Asset::upsert($batch, ['kode_barang', 'nup'], $updateColumns);
        }

        // Update Progress in DB - Count all rows in chunk to keep progress bar moving
        if ($this->importTaskId) {
            $affected = ImportTask::where('id', $this->importTaskId)->increment('processed_rows', $rows->count());
            Log::info("Incremented processed_rows for Task ID: {$this->importTaskId} by {$rows->count()} rows.");
        }
    }

    private function parseDate($value)
    {
        if (empty($value)) return null;
        if ($value instanceof \DateTime) return $value->format('Y-m-d');
        if (is_numeric($value)) return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
        
        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    private function parseNumber($value)
    {
        if (empty($value)) return 0;
        if (is_numeric($value)) return $value;
        return (float) str_replace(['.', ','], ['', '.'], $value);
    }

    public function chunkSize(): int
    {
        return 100; // Reduced from 500 for lower RAM usage per batch
    }

    public function endColumn(): string
    {
        return 'BZ'; // Limit columns to reduce memory footprint
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                ImportTask::where('id', $this->importTaskId)->update([
                    'status' => 'processing',
                    'total_rows' => 0 
                ]);
                
                // REMOVED getTotalRows() because it kills RAM for large files
                // We will rely on processed_rows for progress tracking
            },
            AfterImport::class => function (AfterImport $event) {
                ImportTask::where('id', $this->importTaskId)->update(['status' => 'completed']);
            },
            ImportFailed::class => function (ImportFailed $event) {
                ImportTask::where('id', $this->importTaskId)->update([
                    'status' => 'failed',
                    'error_message' => $event->getException()->getMessage()
                ]);
            },
        ];
    }
}
