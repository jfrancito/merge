<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$vr = DB::table('WEB.VALE_RENDIR')->first();
print_r($vr);

if ($vr) {
    $detalles = DB::table('WEB.VALE_RENDIR_DETALLE')->where('ID', $vr->ID)->get();
    echo "\nDetalles for " . $vr->ID . ": " . count($detalles) . "\n";
    print_r($detalles);
}
