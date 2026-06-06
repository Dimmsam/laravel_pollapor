<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $result = DB::select("SELECT udt_name FROM information_schema.columns WHERE table_name = 'formulir_laporan' AND column_name = 'prioritas';");
    $udt = $result[0]->udt_name;
    
    $enum = DB::select("SELECT e.enumlabel FROM pg_type t JOIN pg_enum e ON t.oid = e.enumtypid WHERE t.typname = '$udt';");
    print_r($enum);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
