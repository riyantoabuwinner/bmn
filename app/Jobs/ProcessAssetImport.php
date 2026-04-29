<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessAssetImport implements ShouldQueue
{
    use Queueable;

    public $timeout = 3600; // 1 hour timeout
    public $tries = 1;

    protected $importId;
    protected $filePath;

    /**
     * Create a new job instance.
     */
    public function __construct($importId, $filePath)
    {
        $this->importId = $importId;
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        try {
            $import = new \App\Imports\AssetsImport($this->importId);
            \Maatwebsite\Excel\Facades\Excel::import($import, $this->filePath);
        } catch (\Exception $e) {
            \Log::error('Background Import Aset Gagal: ' . $e->getMessage());
            // Mark as failed in cache so frontend knows
            \Cache::put("import_processed_{$this->importId}", \Cache::get("import_total_{$this->importId}", 1), now()->addHours(2));
        } finally {
            // Clean up the temporary file
            if (\Storage::exists($this->filePath)) {
                \Storage::delete($this->filePath);
            }
        }
    }
}
