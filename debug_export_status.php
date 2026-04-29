<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Asset;

echo "--- DEBUG START ---\n";
try {
    $jobCount = DB::table('jobs')->count();
    $failedCount = DB::table('failed_jobs')->count();
    $assetCount = Asset::count();

    echo "Jobs in Queue: $jobCount\n";
    echo "Failed Jobs: $failedCount\n";
    echo "Total Assets: $assetCount\n";

    if ($jobCount > 0) {
        $jobs = DB::table('jobs')->get();
        foreach ($jobs as $job) {
            echo "Job ID: {$job->id}, Queue: {$job->queue}, Attempts: {$job->attempts}\n";
            $payload = json_decode($job->payload, true);
            echo "  Class: " . ($payload['displayName'] ?? 'Unknown') . "\n";
        }
    }
}
catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
echo "--- DEBUG END ---\n";
