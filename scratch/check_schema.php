<?php
require __DIR__.'/../bootstrap/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$columns = Schema::getColumnListing('FE_GRUPO_DOCUMENTO');
echo "Columns in FE_GRUPO_DOCUMENTO:\n";
print_r($columns);

// Also check the tables CatContaOrden and UbicacionContaOrden
try {
    $catContaColumns = Schema::getColumnListing('CatContaOrden');
    echo "\nColumns in CatContaOrden:\n";
    print_r($catContaColumns);
} catch (Exception $e) {
    echo "\nError checking CatContaOrden: " . $e->getMessage() . "\n";
}

try {
    $ubicacionContaColumns = Schema::getColumnListing('UbicacionContaOrden');
    echo "\nColumns in UbicacionContaOrden:\n";
    print_r($ubicacionContaColumns);
} catch (Exception $e) {
    echo "\nError checking UbicacionContaOrden: " . $e->getMessage() . "\n";
}
