<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$failed = \DB::table('failed_jobs')->orderBy('failed_at', 'desc')->first();
if ($failed) {
    echo "ID: " . $failed->id . "\n";
    echo "Connection: " . $failed->connection . "\n";
    echo "Queue: " . $failed->queue . "\n";
    echo "Exception: \n" . $failed->exception . "\n";
} else {
    echo "No failed jobs found.\n";
}
