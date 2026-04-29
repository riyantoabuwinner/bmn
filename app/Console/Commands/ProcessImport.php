<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ProcessImport extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'import:process {type} {importId} {filePath}';

    /**
     * The console command description.
     */
    protected $description = 'Process an import file in the background';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $type = $this->argument('type');
        $importId = $this->argument('importId');
        $filePath = $this->argument('filePath');

        $this->info("Starting import: type={$type}, id={$importId}, file={$filePath}");

        try {
            if ($type === 'asset') {
                $import = new \App\Imports\AssetsImport($importId);
            } elseif ($type === 'current_asset') {
                $import = new \App\Imports\CurrentAssetsImport($importId);
            } else {
                $this->error("Unknown import type: {$type}");
                return 1;
            }

            // Check if file exists and get absolute path
            if (!\Storage::exists($filePath)) {
                throw new \Exception("File import tidak ditemukan: {$filePath}");
            }

            $absolutePath = \Storage::path($filePath);
            $this->info("Processing absolute path: {$absolutePath}");
            \Log::info("BackgroundImport Starting: ID={$importId}, File={$absolutePath}");

            // Manual check of rows if possible or just log after BeforeImport event (handled inside import class)
            Excel::import($import, $absolutePath);

            \Log::info("BackgroundImport Finished: ID={$importId}");
            
            $total = \Cache::get("import_total_{$importId}", 0);
            $processed = \Cache::get("import_processed_{$importId}", 0);
            $this->info("Import completed. Total rows processed (approx): {$total}, Processed: {$processed}");

            $this->info("Import completed successfully.");
        } catch (\Exception $e) {
            \Log::error("Background Import ({$type}) Gagal: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            $this->error("Import failed: " . $e->getMessage());

            // Mark as finished so frontend doesn't hang
            $total = \Cache::get("import_total_{$importId}", 1);
            \Cache::put("import_processed_{$importId}", $total, now()->addHours(2));
        } finally {
            // Clean up the temporary file
            if (\Storage::exists($filePath)) {
                \Storage::delete($filePath);
            }
        }

        return 0;
    }
}
