<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
try {
    $columns = Schema::getColumnListing('CONTRATO_ANTICIPO');
    print_r($columns);
    $fe_columns = Schema::getColumnListing('FE_DOCUMENTO');
    print_r($fe_columns);
} catch (Exception $e) {
    echo $e->getMessage();
}
