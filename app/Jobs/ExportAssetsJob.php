<?php

namespace App\Jobs;

use App\Exports\AssetsExport;
use App\Models\Asset;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;

class ExportAssetsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $jobId;

    /**
     * Create a new job instance.
     */
    public function __construct($jobId)
    {
        $this->jobId = $jobId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $total = Asset::count();
        Cache::put('export_progress_' . $this->jobId, 0, 3600);

        // We use store() to save to disk, passing the jobId to the Export class for progress updates
        $fileName = 'exports/data_aset_' . $this->jobId . '.xlsx';
        Excel::store(new AssetsExport($this->jobId, $total), $fileName, 'public');

        // Mark as complete
        Cache::put('export_progress_' . $this->jobId, 100, 3600);
        Cache::put('export_file_' . $this->jobId, $fileName, 3600);
    }
}
