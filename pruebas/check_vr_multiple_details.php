<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$res = DB::table('WEB.VALE_RENDIR_DETALLE')
    ->select('ID', DB::raw('count(*) as c'))
    ->groupBy('ID')
    ->havingRaw('count(*) > 1')
    ->take(5)
    ->get();

print_r($res);
