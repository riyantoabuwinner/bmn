<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $count = \App\Models\Asset::count();
    echo "Asset Count: " . $count . "\n";

    if ($count > 0) {
        $first = \App\Models\Asset::first();
        echo "First Asset: " . $first->nama_barang . "\n";
    }
}
catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
