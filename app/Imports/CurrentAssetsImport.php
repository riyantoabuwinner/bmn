<?php

namespace App\Imports;

use App\Models\CurrentAsset;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Collection;

class CurrentAssetsImport implements ToCollection, WithHeadingRow, WithChunkReading, \Maatwebsite\Excel\Concerns\WithEvents, \Illuminate\Contracts\Queue\ShouldQueue
{
    public $importTaskId;

    public function __construct($importTaskId)
    {
        $this->importTaskId = $importTaskId;
        ini_set('memory_limit', '2G');
        set_time_limit(0);
    }

    public function collection(Collection $rows)
    {
        $batch = [];
        $now = now();

        foreach ($rows as $row) {
            $kodeBarang = $row['kode_barang'] ?? $row['kode_bmn'] ?? null;
            if (empty($kodeBarang)) continue;

            $stokAwal = $row['stok_awal'] ?? $row['kuantitas'] ?? 0;
            $hargaSatuan = $row['harga_satuan'] ?? $row['nilai_perolehan'] ?? 0;

            $batch[] = [
                'kode_barang' => $kodeBarang,
                'nama_barang' => $row['nama_barang'] ?? $row['uraian_barang'] ?? 'Aset Tanpa Nama',
                'kategori' => $row['kategori'] ?? null,
                'stok_awal' => $stokAwal,
                'stok_minimum' => $row['stok_minimum'] ?? 0,
                'stok_tersedia' => $stokAwal,
                'harga_satuan' => $hargaSatuan,
                'nilai_total' => $stokAwal * $hargaSatuan,
                'satuan' => $row['satuan'] ?? 'Unit',
                'lokasi_penyimpanan' => $row['lokasi_penyimpanan'] ?? $row['lokasi'] ?? null,
                'spesifikasi' => $row['spesifikasi'] ?? null,
                'keterangan' => $row['keterangan'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($batch)) {
            \App\Models\CurrentAsset::upsert($batch, ['kode_barang'], array_diff(array_keys($batch[0]), ['created_at']));
        }

        if ($this->importTaskId) {
            \App\Models\ImportTask::where('id', $this->importTaskId)->increment('processed_rows', $rows->count());
        }
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\BeforeImport::class => function (\Maatwebsite\Excel\Events\BeforeImport $event) {
                \App\Models\ImportTask::where('id', $this->importTaskId)->update([
                    'status' => 'processing',
                    'total_rows' => 0
                ]);
                
                try {
                    $totalRows = array_values($event->reader->getTotalRows())[0] - 1;
                    \App\Models\ImportTask::where('id', $this->importTaskId)->update([
                        'total_rows' => $totalRows > 0 ? $totalRows : 0
                    ]);
                } catch (\Exception $e) {}
            },
            \Maatwebsite\Excel\Events\AfterImport::class => function (\Maatwebsite\Excel\Events\AfterImport $event) {
                \App\Models\ImportTask::where('id', $this->importTaskId)->update(['status' => 'completed']);
            },
            \Maatwebsite\Excel\Events\ImportFailed::class => function (\Maatwebsite\Excel\Events\ImportFailed $event) {
                \App\Models\ImportTask::where('id', $this->importTaskId)->update([
                    'status' => 'failed',
                    'error_message' => $event->getException()->getMessage()
                ]);
            },
        ];
    }
}
