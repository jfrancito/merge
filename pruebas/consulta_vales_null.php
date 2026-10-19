<?php
require __DIR__ . '/../bootstrap/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$valesNull = DB::table('WEB.VALE_RENDIR')
    ->whereNull('COD_EMPR_CLIENTE')
    ->orWhere('COD_EMPR_CLIENTE', '')
    ->select('ID', 'TXT_NOM_SOLICITA', 'COD_USUARIO_CREA_AUD', 'FEC_USUARIO_CREA_AUD', 'COD_CATEGORIA_ESTADO_VALE', 'TXT_CATEGORIA_ESTADO_VALE')
    ->get();

echo "Total vales con COD_EMPR_CLIENTE NULL o vacío: " . count($valesNull) . "\n";
print_r($valesNull);
