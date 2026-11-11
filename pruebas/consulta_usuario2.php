<?php
require __DIR__ . '/../bootstrap/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$user2 = DB::table('users')->where('id', '1CIX00000547')->first();
if ($user2) {
    $trab2 = DB::table('STD.TRABAJADOR')->where('COD_TRAB', $user2->usuarioosiris_id)->first();
    if ($trab2) {
        $emps2 = DB::table('STD.EMPRESA')->where('NRO_DOCUMENTO', $trab2->NRO_DOCUMENTO)->get();
        echo "Empresas para CONDOR DIAZ LAZARO (DNI {$trab2->NRO_DOCUMENTO}):\n";
        foreach ($emps2 as $e) {
            echo "COD_EMPR: {$e->COD_EMPR}, FEC_CREA: {$e->FEC_USUARIO_CREA_AUD}, COD_CREA: {$e->COD_USUARIO_CREA_AUD}\n";
        }
    }
}
