<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$fecha_inicio = '2025-01-01';
$fecha_fin = '2025-12-31';
$estado_id = 'TODO';

$queryRendir = DB::table('WEB.VALE_RENDIR as V')
    ->leftJoin('WEB.VALE_RENDIR_DETALLE as D', 'V.ID', '=', 'D.ID')
    ->select(
        'V.ID as ID_MERGE',
        'V.ID_OSIRIS',
        'V.FEC_AUTORIZACION',
        'V.TXT_SERIE as SERIE',
        'V.TXT_NUMERO as NUMERO_DOC',
        'V.COD_CENTRO',
        DB::raw("CASE 
            WHEN V.COD_CENTRO = 'CEN0000000000001' THEN 'CHICLAYO'
            WHEN V.COD_CENTRO = 'CEN0000000000002' THEN 'LIMA'
            WHEN V.COD_CENTRO = 'CEN0000000000004' THEN 'RIOJA'
            WHEN V.COD_CENTRO = 'CEN0000000000006' THEN 'BELLAVISTA'
            ELSE V.COD_CENTRO 
        END as CENTRO"),
        'V.TXT_NOM_SOLICITA as SOLICITANTE',
        'V.TXT_NOM_AUTORIZA as JEFE_AUTORIZA',
        'V.TXT_NOM_APRUEBA as APRUEBA_ADM',
        'V.COD_CONTRATO as CONTRATO',
        'V.SUB_CUENTA',
        'V.COD_MONEDA',
        DB::raw("CASE 
            WHEN V.COD_MONEDA = 'MON0000000000001' THEN 'SOLES'
            WHEN V.COD_MONEDA = 'MON0000000000002' THEN 'DOLARES'
            ELSE V.COD_MONEDA 
        END as MONEDA"),
        'V.TXT_GLOSA as GLOSA',
        'V.CAN_TOTAL_IMPORTE as TOTAL',
        'V.TXT_CATEGORIA_ESTADO_VALE as ESTADO',
        'D.FEC_INICIO',
        'D.FEC_FIN',
        'D.NOM_DESTINO as DESTINO',
        'V.COD_EMPR'
    )
    ->where(function ($query) use ($fecha_inicio, $fecha_fin) {
        $query->whereBetween(DB::raw("CAST(V.FEC_USUARIO_CREA_AUD AS DATE)"), [$fecha_inicio, $fecha_fin])
            ->orWhereBetween(DB::raw("CAST(V.FEC_USUARIO_MODIF_AUD AS DATE)"), [$fecha_inicio, $fecha_fin]);
    })
    ->orderBy('V.COD_CENTRO', 'ASC')
    ->orderBy(DB::raw('LEFT(V.ID, 6)'), 'ASC')
    ->orderBy(DB::raw('CAST(SUBSTRING(V.ID, 7, LEN(V.ID)) AS BIGINT)'), 'DESC')
    ->take(2)
    ->get();

print_r($queryRendir);
