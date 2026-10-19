<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$item = DB::table('LQG_LIQUIDACION_GASTO')->select('ID_DOCUMENTO', 'TXT_EMPRESA_TRABAJADOR', 'TXT_AREA')->whereNotNull('TXT_AREA')->first();
if (!$item) {
    $item = DB::table('LQG_LIQUIDACION_GASTO')->select('ID_DOCUMENTO', 'TXT_EMPRESA_TRABAJADOR', 'TXT_AREA')->first();
}
print_r($item);
