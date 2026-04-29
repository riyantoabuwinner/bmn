<?php

use App\Models\Asset;
use Illuminate\Support\Facades\DB;

// Load Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$csvPath = 'storage/app/bmn_assets_full.csv';
$handle = fopen($csvPath, 'r');

if (!$handle) {
    die("Cannot open CSV\n");
}

// Read Header
$header = fgetcsv($handle);
$header[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $header[0]); // Clean BOM
$header = array_map('trim', $header);

echo "Header Columns found: " . count($header) . "\n";
print_r($header);

$map = array_flip($header);

if (!isset($map['Jenis BMN'])) {
    die("ERROR: 'Jenis BMN' column not found in header!\n");
}

$found = false;
$limit = 5;
$i = 0;

while (($row = fgetcsv($handle)) !== false && $i < $limit) {
    if (count($row) < count($header))
        continue;

    $kode = trim($row[$map['Kode Barang']]);
    $nup = trim($row[$map['NUP']]);
    $jenis = trim($row[$map['Jenis BMN']]);

    if (empty($kode))
        continue;

    echo "\nProcessing Row:\n";
    echo "Kode: $kode | NUP: $nup | Jenis BMN in CSV: '$jenis'\n";

    $asset = Asset::where('kode_barang', $kode)->where('nup', $nup)->first();

    if ($asset) {
        echo "FOUND Asset ID: {$asset->id}\n";
        echo "Current Jenis BMN: '{$asset->jenis_bmn}'\n";

        // Try updateOrCreate
        Asset::updateOrCreate(
        ['kode_barang' => $kode, 'nup' => $nup],
        ['jenis_bmn' => $jenis]
        );

        echo "After UpdateOrCreate Jenis BMN: '{$asset->fresh()->jenis_bmn}'\n";
    }
    else {
        echo "Asset NOT FOUND for Kode: $kode, NUP: $nup\n";
    }

    $i++;
}

fclose($handle);
