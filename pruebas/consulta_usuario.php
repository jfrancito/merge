<?php
require __DIR__ . '/../bootstrap/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$vale = DB::table('WEB.VALE_RENDIR')->where('ID', 'ISRJAU0000000372')->first();
echo "VALE:\n";
print_r($vale);

$user = DB::table('users')->where('id', '1CIX00000545')->first();
echo "\nUSER:\n";
print_r($user);

if ($user) {
    echo "\nTRABAJADOR:\n";
    $trab = DB::table('STD.TRABAJADOR')->where('COD_TRAB', $user->usuarioosiris_id)->first();
    print_r($trab);

    if ($trab) {
        echo "\nEMPRESAS CON NRO_DOCUMENTO ({$trab->NRO_DOCUMENTO}):\n";
        $emps = DB::table('STD.EMPRESA')->where('NRO_DOCUMENTO', $trab->NRO_DOCUMENTO)->get();
        print_r($emps);
    }

    echo "\nTERCEROS CON USER_ID ({$user->id}):\n";
    $ters = DB::table('terceros')->where('USER_ID', $user->id)->get();
    print_r($ters);

    // Let's test the exact query from ValeRendirController:
    $cod_usuario_registro = $user->id;
    $cod_empr_cli1 = DB::table('users as usu')
        ->join('STD.TRABAJADOR as tra', 'tra.COD_TRAB', '=', 'usu.usuarioosiris_id')
        ->join('STD.EMPRESA as emp', 'emp.NRO_DOCUMENTO', '=', 'tra.NRO_DOCUMENTO')
        ->where('usu.id', $cod_usuario_registro)
        ->where('emp.COD_ESTADO', 1)
        ->value('emp.COD_EMPR');
    echo "\nQuery 1 (TRABAJADOR -> EMPRESA): " . var_export($cod_empr_cli1, true) . "\n";

    $cod_empr_cli2 = DB::table('users as usu')
        ->join('terceros as ter', 'ter.USER_ID', '=', 'usu.id')
        ->join('STD.EMPRESA as emp', 'emp.NRO_DOCUMENTO', '=', 'ter.DNI')
        ->where('usu.id', $cod_usuario_registro)
        ->where('emp.COD_ESTADO', 1)
        ->value('emp.COD_EMPR');
    echo "Query 2 (TERCEROS -> EMPRESA): " . var_export($cod_empr_cli2, true) . "\n";
}
