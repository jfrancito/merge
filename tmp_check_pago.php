<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$pago = DB::table('CONTRATO_PAGO')->first();
if($pago) {
    echo json_encode($pago, JSON_PRETTY_PRINT);
} else {
    echo "No records found in CONTRATO_PAGO";
}
