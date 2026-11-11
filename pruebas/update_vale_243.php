<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$v = DB::table('WEB.VALE_RENDIR')->where('ID', 'ISBEAU0000000243')->first();
echo "Before:\n";
print_r($v);

DB::table('WEB.VALE_RENDIR')->where('ID', 'ISBEAU0000000243')->update([
    'COD_EMPR_CLIENTE' => 'ITCHEM0000001076'
]);

$vAfter = DB::table('WEB.VALE_RENDIR')->where('ID', 'ISBEAU0000000243')->first();
echo "After:\n";
print_r($vAfter);
