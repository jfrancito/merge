<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Modelos\LqgLiquidacionGasto;

$proveedor_id = 'TODO';
$estado_id = 'TODO';
$fecha_inicio = '2026-01-01';
$fecha_fin = '2026-12-31';

$listadatos = LqgLiquidacionGasto::join('LQG_DETLIQUIDACIONGASTO', 'LQG_LIQUIDACION_GASTO.ID_DOCUMENTO', '=', 'LQG_DETLIQUIDACIONGASTO.ID_DOCUMENTO')
    ->join('LQG_DETDOCUMENTOLIQUIDACIONGASTO', function($join) {
        $join->on('LQG_DETDOCUMENTOLIQUIDACIONGASTO.ID_DOCUMENTO', '=', 'LQG_DETLIQUIDACIONGASTO.ID_DOCUMENTO')
             ->on('LQG_DETDOCUMENTOLIQUIDACIONGASTO.ITEM', '=', 'LQG_DETLIQUIDACIONGASTO.ITEM');
    })
    ->join('STD.EMPRESA', 'STD.EMPRESA.COD_EMPR', '=', 'LQG_DETLIQUIDACIONGASTO.COD_EMPRESA_PROVEEDOR')
    ->ProveedorLG($proveedor_id)
    ->EstadoLG($estado_id)
    ->whereRaw("CAST(FECHA_EMI AS DATE) >= ? and CAST(FECHA_EMI AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
    ->select([
        'LQG_LIQUIDACION_GASTO.ID_DOCUMENTO',
        'LQG_LIQUIDACION_GASTO.TXT_EMPRESA_TRABAJADOR',
        'LQG_LIQUIDACION_GASTO.TXT_AREA',
        'LQG_LIQUIDACION_GASTO.FECHA_EMI',
        'LQG_DETLIQUIDACIONGASTO.FECHA_EMISION',
        'LQG_DETLIQUIDACIONGASTO.TXT_TIPODOCUMENTO',
        'LQG_DETLIQUIDACIONGASTO.SERIE',
        'LQG_DETLIQUIDACIONGASTO.NUMERO',
        'LQG_DETLIQUIDACIONGASTO.TXT_EMPRESA_PROVEEDOR',
        'STD.EMPRESA.NRO_DOCUMENTO',
        'LQG_DETDOCUMENTOLIQUIDACIONGASTO.TXT_PRODUCTO',
        'LQG_LIQUIDACION_GASTO.TXT_CATEGORIA_MONEDA',
        'LQG_DETDOCUMENTOLIQUIDACIONGASTO.CANTIDAD',
        'LQG_DETDOCUMENTOLIQUIDACIONGASTO.SUBTOTAL',
        'LQG_DETDOCUMENTOLIQUIDACIONGASTO.IGV',
        'LQG_DETDOCUMENTOLIQUIDACIONGASTO.TOTAL',
        'LQG_LIQUIDACION_GASTO.TXT_USUARIO_AUTORIZA',
        DB::raw("(SELECT TOP 1 emailcorp FROM WEB.ListaplatrabajadoresGenereal WHERE COD_TRAB = (SELECT usuarioosiris_id FROM users WHERE id = LQG_LIQUIDACION_GASTO.USUARIO_CREA)) as EMAIL_USUARIO"),
        DB::raw("(SELECT TOP 1 emailcorp FROM WEB.ListaplatrabajadoresGenereal WHERE COD_TRAB = (SELECT usuarioosiris_id FROM users WHERE id = LQG_LIQUIDACION_GASTO.COD_USUARIO_AUTORIZA)) as EMAIL_JEFE")
    ])
    ->distinct()
    ->orderBy('LQG_LIQUIDACION_GASTO.FECHA_EMI', 'desc')
    ->first();

print_r($listadatos);
