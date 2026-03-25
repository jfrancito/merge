<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );

    $columns = Schema::getColumnListing('CONTRATO_PAGO');
    echo "Columns in CONTRATO_PAGO:\n";
    print_r($columns);

    $first = DB::table('CONTRATO_PAGO')->first();
    echo "\nFirst row in CONTRATO_PAGO:\n";
    print_r($first);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
