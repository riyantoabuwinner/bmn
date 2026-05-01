<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Process;

$commands = [
    'git --version',
    'git rev-parse --abbrev-ref HEAD',
    'git rev-parse --short HEAD',
    'git log -1 --format=%cd --date=relative'
];

foreach ($commands as $cmd) {
    echo "Running: $cmd\n";
    $result = Process::run($cmd);
    echo "Exit Code: " . $result->exitCode() . "\n";
    echo "Output: " . $result->output() . "\n";
    echo "Error: " . $result->errorOutput() . "\n";
    echo "--------------------------\n";
}
