<?php
require 'bootstrap/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$fecha_inicio = '2025-01-01';
$fecha_fin = '2025-12-31';
$estado_id = 'TODO';
$tipo_vale = 'TODO';

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
    ->when($estado_id != '' && $estado_id != 'TODO', function ($query) use ($estado_id) {
        $query->where('V.COD_CATEGORIA_ESTADO_VALE', '=', $estado_id);
    })
    ->where(function ($query) use ($fecha_inicio, $fecha_fin) {
        $query->whereBetween(DB::raw("CAST(V.FEC_USUARIO_CREA_AUD AS DATE)"), [$fecha_inicio, $fecha_fin])
            ->orWhereBetween(DB::raw("CAST(V.FEC_USUARIO_MODIF_AUD AS DATE)"), [$fecha_inicio, $fecha_fin]);
    });

$queryReembolso = DB::table('WEB.VALE_RENDIR_REEMBOLSO as R')
    ->leftJoin('WEB.VALE_RENDIR_DETALLE_REEMBOLSO as D', 'R.ID', '=', 'D.ID')
    ->select(
        'R.ID as ID_MERGE',
        'R.ID_OSIRIS',
        'R.FEC_AUTORIZACION',
        'R.TXT_SERIE as SERIE',
        'R.TXT_NUMERO as NUMERO_DOC',
        'R.COD_CENTRO',
        DB::raw("CASE 
            WHEN R.COD_CENTRO = 'CEN0000000000001' THEN 'CHICLAYO'
            WHEN R.COD_CENTRO = 'CEN0000000000002' THEN 'LIMA'
            WHEN R.COD_CENTRO = 'CEN0000000000004' THEN 'RIOJA'
            WHEN R.COD_CENTRO = 'CEN0000000000006' THEN 'BELLAVISTA'
            ELSE R.COD_CENTRO 
        END as CENTRO"),
        'R.TXT_NOM_SOLICITA as SOLICITANTE',
        'R.TXT_NOM_AUTORIZA as JEFE_AUTORIZA',
        'R.TXT_NOM_APRUEBA as APRUEBA_ADM',
        'R.COD_CONTRATO as CONTRATO',
        'R.SUB_CUENTA',
        'R.COD_MONEDA',
        DB::raw("CASE 
            WHEN R.COD_MONEDA = 'MON0000000000001' THEN 'SOLES'
            WHEN R.COD_MONEDA = 'MON0000000000002' THEN 'DOLARES'
            ELSE R.COD_MONEDA 
        END as MONEDA"),
        'R.TXT_GLOSA as GLOSA',
        'R.CAN_TOTAL_IMPORTE as TOTAL',
        'R.TXT_CATEGORIA_ESTADO_VALE as ESTADO',
        'D.FEC_INICIO',
        'D.FEC_FIN',
        'D.NOM_DESTINO as DESTINO',
        'R.COD_EMPR'
    )
    ->when($estado_id != '' && $estado_id != 'TODO', function ($query) use ($estado_id) {
        $query->where('R.COD_CATEGORIA_ESTADO_VALE', '=', $estado_id);
    })
    ->where(function ($query) use ($fecha_inicio, $fecha_fin) {
        $query->whereBetween(DB::raw("CAST(R.FEC_USUARIO_CREA_AUD AS DATE)"), [$fecha_inicio, $fecha_fin])
            ->orWhereBetween(DB::raw("CAST(R.FEC_USUARIO_MODIF_AUD AS DATE)"), [$fecha_inicio, $fecha_fin]);
    });

$unionSql = $queryRendir->unionAll($queryReembolso)->toSql();
$listavale = DB::table(DB::raw("($unionSql) as VALES"))
    ->mergeBindings($queryRendir)
    ->orderBy('COD_CENTRO', 'ASC')
    ->orderBy(DB::raw('LEFT(ID_MERGE, 6)'), 'ASC')
    ->orderBy(DB::raw('CAST(SUBSTRING(ID_MERGE, 7, LEN(ID_MERGE)) AS BIGINT)'), 'DESC')
    ->take(3)
    ->get();

echo "Total records found: " . count($listavale) . "\n";
print_r($listavale[0]);

