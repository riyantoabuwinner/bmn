<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Exports\AssetsExport;
use Maatwebsite\Excel\Facades\Excel;

echo "Testing AssetsExport...\n";

try {
    $export = new AssetsExport();
    echo "Instance created successfully.\n";

    $query = $export->query();
    echo "Query: " . $query->toSql() . "\n";

    echo "Attempting to store file...\n";
    Excel::store($export, 'exports/test_sync.xlsx', 'public');
    echo "File stored successfully.\n";


}
catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
