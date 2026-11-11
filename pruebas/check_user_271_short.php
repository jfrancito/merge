<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$u = DB::table('users')->where('id', '1CIX00000271')->first();
echo "=== USER 1CIX00000271 ===\n";
print_r($u);

$trab = DB::table('STD.TRABAJADOR')->where('COD_TRAB', $u->usuarioosiris_id)->first();
echo "\n=== STD.TRABAJADOR ===\n";
print_r($trab);

if ($trab) {
    $emp = DB::table('STD.EMPRESA')->where('NRO_DOCUMENTO', $trab->NRO_DOCUMENTO)->get();
    echo "\n=== STD.EMPRESA with NRO_DOCUMENTO '{$trab->NRO_DOCUMENTO}' ===\n";
    print_r($emp);
}

$vale = DB::table('WEB.VALE_RENDIR')->where('ID', 'ISBEAU0000000243')->first();
echo "\n=== VALE ISBEAU0000000243 ===\n";
print_r($vale);

$pastVales271 = DB::table('WEB.VALE_RENDIR')->where('COD_USUARIO_CREA_AUD', '1CIX00000271')->get();
echo "\n=== ALL VALES FROM 1CIX00000271: " . count($pastVales271) . " ===\n";
foreach ($pastVales271 as $pv) {
    echo "ID: {$pv->ID}, COD_EMPR_CLIENTE: '{$pv->COD_EMPR_CLIENTE}', TXT_NOM_SOLICITA: '{$pv->TXT_NOM_SOLICITA}'\n";
}
