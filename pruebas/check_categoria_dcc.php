<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$cat = DB::table('CMP.CATEGORIA')->where('COD_CATEGORIA', 'DCC0000000000006')->first();
print_r($cat);

$docs = DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_CATEGORIA_DOCUMENTO', 'DCC0000000000006')->take(5)->get();
print_r($docs);
