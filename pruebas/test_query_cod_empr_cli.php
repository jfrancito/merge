<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$users = ['1CIX00000271', '1CIX00000398', '1CIX00000080', '1CIX00000401'];

foreach ($users as $cod_usuario_registro) {
    $cod_empr_cli = DB::table('users as usu')
        ->join('STD.TRABAJADOR as tra', 'tra.COD_TRAB', '=', 'usu.usuarioosiris_id')
        ->join('STD.EMPRESA as emp', 'emp.NRO_DOCUMENTO', '=', 'tra.NRO_DOCUMENTO')
        ->where('usu.id', $cod_usuario_registro)
        ->where('emp.COD_ESTADO', 1)
        ->value('emp.COD_EMPR');

    if (!$cod_empr_cli) {
        $cod_empr_cli = DB::table('users as usu')
            ->join('terceros as ter', 'ter.USER_ID', '=', 'usu.id')
            ->join('STD.EMPRESA as emp', 'emp.NRO_DOCUMENTO', '=', 'ter.DNI')
            ->where('usu.id', $cod_usuario_registro)
            ->where('emp.COD_ESTADO', 1)
            ->value('emp.COD_EMPR');
    }

    echo "User $cod_usuario_registro -> COD_EMPR_CLI: $cod_empr_cli\n";
}
