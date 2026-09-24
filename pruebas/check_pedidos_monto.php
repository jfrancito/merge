<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$pedidos = DB::table('WEB.ORDEN_PEDIDO as OP')
    ->join('WEB.ORDEN_PEDIDO_DETALLE as OPD', 'OPD.ID_PEDIDO', '=', 'OP.ID_PEDIDO')
    ->where('OP.ACTIVO', 1)
    ->where('OPD.ACTIVO', 1)
    ->where('OPD.IND_MATERIAL_SERVICIO', 'S')
    ->groupBy('OP.ID_PEDIDO', 'OP.COD_TRABAJADOR_APRUEBA_ADM', 'OP.TXT_TRABAJADOR_APRUEBA_ADM', 'OP.COD_ESTADO', 'OP.TXT_ESTADO')
    ->select(
        'OP.ID_PEDIDO',
        'OP.COD_TRABAJADOR_APRUEBA_ADM',
        'OP.TXT_TRABAJADOR_APRUEBA_ADM',
        'OP.COD_ESTADO',
        'OP.TXT_ESTADO',
        DB::raw('SUM(OPD.CANTIDAD * ISNULL(OPD.CAN_PRECIO, 0)) as TOTAL_MONTO')
    )
    ->orderBy('TOTAL_MONTO', 'desc')
    ->take(20)
    ->get();

print_r($pedidos);
