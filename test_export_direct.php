<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Exports\AssetsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;

$jobId = 'test_' . time();
$total = 10;
Cache::put('export_progress_' . $jobId, 0);

echo "Starting export for Job ID: $jobId\n";

try {
    $fileName = 'exports/test_export_' . $jobId . '.xlsx';
    Excel::store(new AssetsExport($jobId, $total), $fileName, 'public');

    echo "Export stored to: $fileName\n";
    echo "Progress in Cache: " . Cache::get('export_progress_' . $jobId) . "\n";


}
catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
