<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $result = DB::select("SELECT column_default FROM information_schema.columns WHERE table_name = 'formulir_laporan' AND column_name = 'prioritas';");
    print_r($result);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
