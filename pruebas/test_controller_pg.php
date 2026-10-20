<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

DB::table('CMP.DOC_ASOCIAR_COMPRA')->where('COD_ORDEN', 'IILMGTO000001394')->delete();
echo "Deleted test records successfully.\n";
