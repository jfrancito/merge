<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$vr = DB::table('WEB.VALE_RENDIR')->first();
echo "--- WEB.VALE_RENDIR ---\n";
print_r(array_keys((array)$vr));

$vrd = DB::table('WEB.VALE_RENDIR_DETALLE')->first();
echo "\n--- WEB.VALE_RENDIR_DETALLE ---\n";
print_r(array_keys((array)$vrd));

$vrr = DB::table('WEB.VALE_RENDIR_REEMBOLSO')->first();
echo "\n--- WEB.VALE_RENDIR_REEMBOLSO ---\n";
if ($vrr) {
    print_r(array_keys((array)$vrr));
} else {
    echo "Empty table\n";
}

$vrrd = DB::table('WEB.VALE_RENDIR_DETALLE_REEMBOLSO')->first();
echo "\n--- WEB.VALE_RENDIR_DETALLE_REEMBOLSO ---\n";
if ($vrrd) {
    print_r(array_keys((array)$vrrd));
} else {
    echo "Empty table\n";
}
