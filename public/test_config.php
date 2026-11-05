<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = \DB::connection();
echo "Database Connection Driver: " . $conn->getDriverName() . "\n";
echo "Database Name: " . $conn->getDatabaseName() . "\n";
try {
    $hasColumnCod = \Schema::hasColumn('productos', 'cod_prod_sunat');
    $hasColumnReg = \Schema::hasColumn('productos', 'bien_regulado');
    echo "Has cod_prod_sunat: " . ($hasColumnCod ? 'YES' : 'NO') . "\n";
    echo "Has bien_regulado: " . ($hasColumnReg ? 'YES' : 'NO') . "\n";
} catch (\Exception $e) {
    echo "Schema check failed: " . $e->getMessage() . "\n";
}
