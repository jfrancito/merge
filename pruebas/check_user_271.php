<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$u = DB::table('users')->where('id', '1CIX00000271')->first();
echo "=== USER 1CIX00000271 ===\n";
print_r($u);

$us_sgd = DB::table('SGD.USUARIO')->where('COD_TRABAJADOR', $u->usuarioosiris_id)->first();
echo "\n=== SGD.USUARIO ===\n";
print_r($us_sgd);

$trab = DB::table('STD.TRABAJADOR')->where('COD_TRAB', $u->usuarioosiris_id)->first();
echo "\n=== STD.TRABAJADOR ===\n";
print_r($trab);

if ($trab) {
    $emp = DB::table('STD.EMPRESA')->where('NRO_DOCUMENTO', $trab->NRO_DOCUMENTO)->get();
    echo "\n=== STD.EMPRESA with NRO_DOCUMENTO {$trab->NRO_DOCUMENTO} ===\n";
    print_r($emp);
}

// Let's also check past vales in WEB.VALE_RENDIR to see what COD_EMPR_CLIENTE was saved in past records!
echo "\n=== PAST VALES COD_EMPR_CLIENTE ===\n";
$pastVales = DB::table('WEB.VALE_RENDIR')
    ->where('COD_USUARIO_CREA_AUD', '1CIX00000271')
    ->orderBy('FEC_USUARIO_CREA_AUD', 'desc')
    ->take(5)
    ->get();
print_r($pastVales);

$sampleVales = DB::table('WEB.VALE_RENDIR')
    ->whereNotNull('COD_EMPR_CLIENTE')
    ->orderBy('FEC_USUARIO_CREA_AUD', 'desc')
    ->take(5)
    ->get();
echo "\n=== PAST VALES WITH NON-NULL COD_EMPR_CLIENTE ===\n";
print_r($sampleVales);
